<?php

namespace App\Listeners;

use App\Models\ChatMessage;
use Illuminate\Auth\Events\Login;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class MergeGuestChatAfterLogin
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Login $event): void
    {
        $guestToken = request()->cookie('chat_token');

        if($guestToken) {
            ChatMessage::where('guest_token', $guestToken)
            ->update([
                'user_id' => $event->user->id,
                'guest_token' => null
            ]);

            cookie()->queue(cookie()->forget('chat_token'));
        }
    }
}
