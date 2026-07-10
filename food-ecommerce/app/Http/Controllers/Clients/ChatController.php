<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Models\ChatMessage;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class ChatController extends Controller
{
    public function fetchMessages(Request $request)
    {
        if (Auth::check()) {
            $msgs = ChatMessage::where('user_id', Auth::id())->orderBy('created_at')->get();
        } else {
            $token = $request->cookie('chat_token');
            $msgs = $token ? ChatMessage::where('guest_token', $token)->orderBy('created_at')->get() : collect();
        }
        return response()->json($msgs);
    }

    // Send message (save user message, call RAG API, save bot reply)
    public function sendMessages(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:2000',
        ]);

        $userId = Auth::id();

        //--Handler guest token (cookie)
        $guestToken = null;
        if (!$userId) {
            $guestToken = $request->cookie('chat_token');
            if (!$guestToken) {
                $guestToken = 'guest_' . Str::random(32);
                // queue cookie to return to clients (180 days)
                cookie()->queue(cookie('chat_token', $guestToken, 60 * 24 * 180));
            }
        }

        // Check if user wants to reset chat history
        $messageText = trim($request->message);
        $normalizedText = mb_strtolower($messageText, 'UTF-8');
        $normalizedText = preg_replace('/\s+/', ' ', $normalizedText);
        if ($normalizedText === 'bắt đầu lại' || $normalizedText === 'bat dau lai') {
            if ($userId) {
                ChatMessage::where('user_id', $userId)->delete();
            } else {
                if ($guestToken) {
                    ChatMessage::where('guest_token', $guestToken)->delete();
                }
            }
            return response()->json([
                'cleared' => true
            ]);
        }

        // 1) Save message user to DB
        $userMsg = ChatMessage::create([
            'user_id' => $userId,
            'guest_token' => $userId ? null : $guestToken,
            'sender' => 'user',
            'message' => $request->message
        ]);

        // 2) Get chat history (6 messages ~ 3 turns user-bot)
        $history = ChatMessage::query()->where(function($q) use ($userId, $guestToken) {
            if ($userId) {
                $q->where('user_id', $userId);
            } else {
                $q->where('guest_token', $guestToken);
            }
        })
        ->latest()
        ->limit(6)
        ->orderBy('created_at', 'asc')
        ->get();

        // Format history for FastAPI RAG service
        $formattedHistory = [];
        foreach ($history as $msg) {
            // Skip the message we just saved to avoid duplicates
            if ($msg->id === $userMsg->id) {
                continue;
            }
            $formattedHistory[] = [
                'role' => $msg->sender === 'user' ? 'user' : 'model',
                'message' => $msg->message
            ];
        }

        // 3) Call RAG service API
        $aiReplyText = "Dạ, hiện tại em đang gặp chút sự cố kết nối với hệ thống. Chị/Anh vui lòng thử lại sau giây lát nhé!";

        $ragUrl = env('RAG_SERVICE_URL', 'http://127.0.0.1:8000');

        try {
            $response = Http::timeout(30)->post("{$ragUrl}/api/chat", [
                'query' => $request->message,
                'history' => $formattedHistory
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $aiReplyText = $data['answer'] ?? "Dạ, hiện tại em chưa tìm được câu trả lời phù hợp.";
            } else {
                Log::error('RAG Service API returned error', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
            }
        } catch (\Throwable $e) {
            Log::error('Failed to connect to RAG service: ' . $e->getMessage());
        }

        // 4) Save bot reply
        $botMsg = ChatMessage::create([
            'user_id' => $userId,
            'guest_token' => $userId ? null : $guestToken,
            'sender' => 'bot',
            'message' => $aiReplyText,
        ]);

        // 5) Return 2 messages created (clients append)
        return response()->json([
            'user' => $userMsg,
            'bot' => $botMsg,
        ]);
    }
}
