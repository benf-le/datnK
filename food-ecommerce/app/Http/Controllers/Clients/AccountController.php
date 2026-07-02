<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\ShippingAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AccountController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $addresses = ShippingAddress::where('user_id', Auth::id())->get();
        $orders = Order::where('user_id', $user->id)->orderBy('created_at', 'desc')->get();

        return view('clients.pages.account', compact('user', 'addresses', 'orders'));
    }

    // Update information
    public function update(Request $request)
    {
        $request->validate([
            'ltn__name' => 'required|string|max:255',
            'ltn__phone_number' => 'nullable|string|max:15',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = Auth::user();

        //handle avatar
        if ($request->hasFile('avatar')) {
            //Delete old photos if exits
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }
            $file = $request->file('avatar');
            //Create new name with timestamp
            $filename = time() . '_' . uniqid() . '_' . $file->getClientOriginalExtension();

            //Save image to folder
            $avatarPath = $file->storeAs('uploads/users', $filename, 'public');
            $user->avatar = $avatarPath;
        }

        $user->name = $request->input('ltn__name');
        $user->phone_number = $request->input('ltn__phone_number');
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Cập nhật thông tin thành công.',
            'avatar' => asset('storage/' . $user->avatar)
        ]);
    }

    // Change password
    public function changePassword(Request $request)
    {
        $request->validate(
            [
                'current_password' => 'required',
                'new_password' => 'required|min:6',
                'confirm_new_password' => 'required|same:new_password',
            ],
            [
                'current_password.required' => 'Vui lòng nhập mật khẩu hiện tại.',
                'new_password.required' => 'Vui lòng nhập mật khẩu mới.',
                'new_password.min' => 'Mật khẩu mới phải có ít nhất 6 kí tự.',
                'confirm_new_password.required' => 'Vui lòng nhập lại mật khẩu mới.',
                'confirm_new_password.same' => 'Mật khẩu nhập lại không khớp.',
            ]
        );

        $user = Auth::user();

        //Check if current password incorrect
        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json(['errors' => ['current_password' => ['Mật khẩu hiện tại không đúng.']]], 422);
        }

        //Update new password
        $user->update(['password' => Hash::make($request->new_password)]);

        return response()->json([
            'success' => true,
            'message' => 'Đổi mật khẩu thành công.',
        ]);
    }

    public function addAddress(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'ward' => 'nullable|string|max:100',
            'district' => 'required|string|max:100',
            'city' => 'required|string|max:100',
        ]);

        if ($request->has('is_default')) {
            ShippingAddress::where('user_id', Auth::id())->update(['is_default' => 0]);
        }

        ShippingAddress::create([
            'user_id' => Auth::id(),
            'full_name' => $request->full_name,
            'phone' => $request->phone,
            'address' => $request->address,
            'ward' => $request->ward,
            'district' => $request->district,
            'city' => $request->city,
            'is_default' => $request->has('is_default') ? 1 : 0,
        ]);

        return back()->with('success', 'Thêm địa chỉ thành công');
    }

    public function updatePrimaryAddress($id)
    {
        //Find address
        $address = ShippingAddress::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        ShippingAddress::where('user_id', Auth::id())->update(['is_default' => 0]);
        $address->update(['is_default' => 1]);

        toastr()->success('Địa chỉ mặc định đã được cập nhật!');
        return back();
    }

    public function deleteAddress($id)
    {
        ShippingAddress::where('id', $id)->where('user_id', Auth::id())->delete();

        toastr()->success('Địa chỉ đã được xóa!');
        return back();
    }
}
