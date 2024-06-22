<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Tymon\JWTAuth\Facades\JWTAuth;


class APIAuthController extends Controller
{
    public function loGin(Request $request)
    { 
        $credentials = $request->only(['email', 'password']);

        $cusTomer = Customer::where('email', $credentials['email'])->where('status', 1)->first();

        if (!$cusTomer || !Hash::check($credentials['password'], $cusTomer->password)) {
            return response()->json(['error' => 'Đăng nhập không thành công'], 401);
        }

        $token = auth('api')->login($cusTomer);

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
            'access_token'=>$token,
            'token_type'=>'bearer',
            'expires_in'=>JWTAuth::factory()->getTTL()*60,
        ]);
    }
    public function sendEmail(Request $request){
        
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

        Mail::send('email', $data, function($message) use ($cusTomer) {
            $message->to($cusTomer->email)->subject('Mật Khẩu Mới');
        });

        return response()->json([
            'access' => true,
            'message' => 'Email với mật khẩu mới đã được gửi!'
        ]);
    }
}
