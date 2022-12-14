<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\SignupRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\ResetPasswordRequest;
use Exception;

class UserAuthService
{
    /**
     * 註冊帳號
     * @param SignupRequest $request
     * @return JsonResponse
     */

    public static function signup(SignupRequest $request)
    {
        $user = new User();
        $user->account = $request->input('account');
        $user->phone_no = $request->input('phone_no');
        $user->password = bcrypt($request->input('password'));

        if (User::where('account', '=', $user['account'])->get()->count() > 0) {
            throw new Exception();
        }

        if (User::where('phone_no', '=', $user['phone_no'])->get()->count() > 0) {
            throw new Exception();
        }

        $user->save();

        $credentials = $request->only(['account', 'password']);

        $token = auth()->attempt($credentials);

        return $token;
    }

    /**
     * 登入取得Token
     * @param Request $request
     * @return JsonResponse
     */

    public static function login(LoginRequest $request)
    {
        $user = User::where('account', $request->account)->first();

        if ($user == null) {
            throw new Exception();
        }

        $user->makeVisible(['password']);

        if (!Hash::check($request->password, $user->password)) {
            throw new Exception();
        }

        $credentials = $request->only(['account', 'password']);

        if ($token = auth()->attempt($credentials)) {
            return $token;
        } else {
            throw new Exception();
        }
    }

    /**
     * 重製密碼
     * @param Request $request
     * @return JsonResponse
     */

    public static function resetPassword(ResetPasswordRequest $request)
    {
        $user = new User();

        try {
            //找到舊的密碼
            $user = User::where('account', $request->account)->first()->makeVisible(['password']);
            //確認輸入的密碼和新的密碼相同
            if (Hash::check($request->oldPassword, $user->password)) {
                $newPassword = bcrypt($request->input('newPassword'));
                $user->password = $newPassword;
                $user->save();

                Auth::logout();

                return response()
                    ->json([
                        'status' => true,
                        'message' => 'ResetPassword successful'
                    ], 200);
            }

            throw new Exception('Password reset failed , please try again');
        } catch (\Exception $e) {
            return response()
                ->json([
                    'status' => false,
                    'message' => 'Password reset failed , please try again'
                ], 400);
        }
    }

    /**
     * 登出帳號
     * 
     * @return JsonResponse
     */

    public static function logout()
    {
        try {
            Auth::logout();

            return response()
                ->json([
                    'status' => true,
                    'message' => 'Successfully logged out.'
                ], 200);
        } catch (\Exception $e) {
            return $e;
        }
    }
}
