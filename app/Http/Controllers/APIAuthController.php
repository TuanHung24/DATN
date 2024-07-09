<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerRequest;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Tymon\JWTAuth\Claims\Custom;
use Tymon\JWTAuth\Facades\JWTAuth;


class APIAuthController extends Controller
{
    public function loGin(Request $request)
    {
        $credentials = $request->only(['email', 'password']);

        $customer = Customer::where('email', $credentials['email'])->first();

        if (!$customer || !Hash::check($credentials['password'], $customer->password)) {
            return response()->json(['error' => 'Email hoặc mật khẩu không chính xác!'], 401);
        }

        if ($customer->status === 0) {
            return response()->json(['error' => 'Tài khoản của bạn đã bị khoá! Vui lòng liên hệ hỗ trợ.'], 401);
        }

        $token = auth('api')->login($customer);

        return $this->respondWithToken($token);
    }


    public function logout()
    {
        auth('api')->logout();
        return response()->json(['message' => 'Đăng xuất thành công!']);
    }

    public function me()
    {

        return response()->json([auth('api')->user()]);
    }

    protected function respondWithToken($token)
    {

        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 60,
        ]);
    }

    public function refreshToken(Request $request)
    {
        try {
            $user = $request->user();

            if (!$user) {
                return response()->json(['message' => 'Unauthorized'], 401);
            }


            $user->tokens()->delete();


            $token = $user->createToken('AccessToken')->plainTextToken;

            return response()->json([
                'access_token' => $token,
                'message' => 'Token refreshed successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error refreshing token'], 500);
        }
    }


    public function sendEmail(Request $request)
    {

        $cusTomer = Customer::where('email', $request->email)->first();

        if (!$cusTomer) {
            return response()->json([
                'access' => false,
                'message' => 'Email không tồn tại!',
            ]);
        }

        $numbers = range(0, 9);
        $randomPassword = '';
        for ($i = 0; $i < 6; $i++) {
            $randomPassword .= $numbers[mt_rand(0, 9)];
        }

        $cusTomer->password = Hash::make($randomPassword);
        $cusTomer->save();


        $data = [
            'name' => $cusTomer->name,
            'password' => $randomPassword,
        ];

        Mail::send('email', $data, function ($message) use ($cusTomer) {
            $message->to($cusTomer->email)->subject('Mật Khẩu Mới');
        });

        return response()->json([
            'access' => true,
            'message' => 'Email với mật khẩu mới đã được gửi!'
        ]);
    }

    public function reGister(CustomerRequest $request)
    {
        $cusTomer = Customer::where('email', $request->email)->first();

        if (!empty($cusTomer)) {
            return response()->json([
                'success' => false,
                'message' => 'Email đã tồn tại!'
            ]);
        }
        $cusTomer = new Customer();
        $cusTomer->name = $request->name;
        $cusTomer->email = $request->email;
        $cusTomer->password = Hash::make($request->password);
        $cusTomer->phone = $request->phone;
        $cusTomer->address = $request->address;
        $cusTomer->save();
        return response()->json([
            'success' => true,
            'message' => 'Đăng ký tài khoản thành công!',
            'customer_id' => $cusTomer->id
        ]);
    }
    public function updateInfo(Request $request)
    {

        $customer = Customer::findOrFail($request->id);

        if (empty($customer)) {
            return response()->json([
                'success' => false,
                'message' => 'Khách hàng không tồn tại!'
            ]);
        }


        $existingCustomer = Customer::where('email', $request->email)->where('id', '<>', $request->id)->first();

        if ($existingCustomer) {
            return response()->json([
                'success' => false,
                'message' => 'Email đã được sử dụng bởi khách hàng khác!'
            ]);
        }
        $customer->email = $request->email;
        $customer->name = $request->name;
        $customer->phone = $request->phone;
        $customer->address = $request->address;
        $customer->save();

        return response()->json([
            'success' => true,
            'data' => $customer,
            'message' => 'Cập nhật tài khoản thành công!'
        ]);
    }

    public function resetPassword(Request $request)
    {


        $request->validate([
            'oldPassword' => 'required',
            'newPassword' => 'required|min:6|max:40',
            'email' => 'required|email'
        ]);

        $user = Customer::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                "success" => false,
                "message" => "Người dùng không tồn tại!",
            ]);
        }

        if (!Hash::check($request->oldPassword, $user->password)) {
            return response()->json([
                "success" => false,
                "message" => "Mật khẩu không chính xác!",
            ]);
        }

        $user->password = Hash::make($request->newPassword);
        $user->save();
        return response()->json(['message' => 'Mật khẩu đã được cập nhật thành công']);
    }
}
