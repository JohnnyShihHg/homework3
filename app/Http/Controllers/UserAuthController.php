<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UserAuthService;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\SignupRequest;

class UserAuthController extends Controller
{
    protected $UserAuthService;

    public function __construct(UserAuthService $UserAuthService)
    {
        $this->middleware('jwt.auth', ['except' => ['login', 'signup']]);

        $this->UserAuthService = $UserAuthService;
    }

    /**
     * 註冊帳號
     * @param SignupRequest $request
     * @return JsonResponse
     */

    public function signup(SignupRequest $request)
    {
        $token = $this->UserAuthService->signup($request);

        if ($token == false) {
            return response()->json([
                'status' => false,
                'message' => 'DUPLICATE_DATA',
            ], 400);
        } else {
            return  response()->json([
                'status' => true,
                'token' => $token,
                'message' => 'account created successfully'
            ], 200);
        }
    }

    /**
     * 登入取得Token
     * @param LoginRequest $request
     * @return JsonResponse
     */

    public function login(LoginRequest $request)
    {
        $token = $this->UserAuthService->login($request);

        if ($token == false) {
            return response()->json([
                'status' => false,
                'message' => 'DATA_ERROR . Please try again or try another account & password',
            ], 400);
        }

        return $this->respondWithToken($token);
    }

    /**
     * 重製密碼
     * @param Request $request
     * @return JsonResponse
     */

    public function resetPassword(Request $request)
    {
        $result = $this->UserAuthService->resetPassword($request);

        return $result;
    }

    /**
     * 登出帳號
     * 
     * @return JsonResponse
     */

    public function logout()
    {
        return $this->UserAuthService->logout();
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
