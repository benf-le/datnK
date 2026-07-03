<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $page = $request->get('page', 1);
            $users = User::with('role')->forPage($page, 9)->get();
            $totalUsers = User::count();
            $totalPages = ceil($totalUsers / 9);
            $hasMore = $page < $totalPages;

            return response()->json([
                'users' => $users->toArray(),
                'has_more' => $hasMore,
                'next_page' => $page + 1,
            ]);
        }

        $users = User::with('role')->paginate(9);
        return view('admin.pages.users', compact('users'));
    }

    /**
     * upgrade a user to staff role
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function upgrade(Request $request)
    {
        $userId = $request->user_id;

        $user = User::find($userId);

        if (!$user) {
            return redirect()->json([
                'status' => false,
                'message' => 'Không tìm thấy người dùng.',
            ]);
        }

        $staffRole = \App\Models\Role::whereRaw('LOWER(name) = ?', ['staff'])->first();
        $user->role_id = $staffRole ? $staffRole->id : 4;
        $user->save();

        return response()->json([
            'status' => true,
            'message' => 'Người dùng này đã trở thành nhân viên.',
        ]);
    }

    public function updateStatus(Request $request)
    {
        $userId = $request->user_id;
        $status = $request->status;

        $user = User::find($userId);

        if (!$user) {
            return redirect()->json([
                'status' => false,
                'message' => 'Không tìm thấy người dùng.',
            ]);
        }

        $user->status = $status; 
        $user->save();

        return response()->json([
            'status' => true,
            'message' => 'Trạng thái người dùng đã được cập nhật.',
        ]);
    }
}
