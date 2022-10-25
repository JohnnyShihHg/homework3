<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UserAuthService;

class UserAuthController extends Controller
{
    protected $UserAuthService;

    public function __construct(UserAuthService $UserAuthService)
    {
        $this->middleware('jwt.auth', ['except' => ['login', 'signup']]);

        $this->UserAuthService = $UserAuthService;
    }

    /**
     * @OA\Post(
     *   tags={"UserAuth"},
     *   path="/user/signup",
     *   summary="註冊身分",
     *   @OA\RequestBody(
     *     @OA\MediaType(
     *          mediaType="multipart/form-data",
     *   @OA\Schema(
     *         required={"account","password","phone_no"},
     *         @OA\Property(property="account", type="string", description="帳號不可重複", example="account123"),
     *         @OA\Property(property="password", type="string", description="密碼", example="test123"),
     *         @OA\Property(property="phone_no", type="string", description="手機號碼不可重複", example="0800092000"),
     *       )
     *     )
     *   ),
     *   @OA\Response(response=200, description="Account created successfully",
     *      content={
     *          @OA\MediaType(
     *              mediaType="application/json",
     *                 example=
     *                    {
     *                         "status": true,
     *                         "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC8xMjcuMC4wLjE6ODAwMFwvYXBpXC91c2VyXC9zaWdudXAiLCJpYXQiOjE2NjY2OTU1ODIsImV4cCI6MTY2NjY5OTE4MiwibmJmIjoxNjY2Njk1NTgyLCJqdGkiOiJyU1pVU1JBNXRKbzROeEl0Iiwic3ViIjo2LCJwcnYiOiIyM2JkNWM4OTQ5ZjYwMGFkYjM5ZTcwMWM0MDA4NzJkYjdhNTk3NmY3In0.dm55q_RYXnsvTKNGMMjjsnqA-qzMJ6TSvjY1WSBmz4s",
     *                         "message": "Account created successfully"
     *                   }
     *          )
     *       }
     *   ),
     * @OA\Response(response=400, description="Account or Phone number already existence",
     * content={
     *          @OA\MediaType(
     *              mediaType="application/json",
     *                 example=
     *                    {
     *                         "status": false,
     *                         "message": "Account or Phone number already existence"
     *                   }
     *          )
     *       }),
     * )
     */

    public function signup(Request $request)
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
     * @OA\Post(
     *   tags={"UserAuth"},
     *   path="/user/login",
     *   summary="登入身分",
     *   @OA\RequestBody(
     *     @OA\MediaType(
     *          mediaType="multipart/form-data",
     *   @OA\Schema(
     *         required={"account","password"},
     *         @OA\Property(property="account", type="string", description="帳號", example="account123"),
     *         @OA\Property(property="password", type="string", description="密碼", example="test123"),
     *       )
     *     )
     *   ),
     *   @OA\Response(response=200, description="Account created successfully",
     *      content={
     *          @OA\MediaType(
     *              mediaType="application/json",
     *                 example=
     *                    {
     *                        "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC8xMjcuMC4wLjE6ODAwMFwvYXBpXC91c2VyXC9sb2dpbiIsImlhdCI6MTY2NjY5NTY1MSwiZXhwIjoxNjY2Njk5MjUxLCJuYmYiOjE2NjY2OTU2NTEsImp0aSI6IjNLdFZLSE85YmVLOXpMY1oiLCJzdWIiOjMsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjcifQ.3gVjsWr_Ri4XOymAsZMhXK_rBOq8EwDFwCKXRzIN52M",
     *                         "token_type": "bearer",
     *                         "expires_in": 3600
     *                   }
     *          )
     *       }
     *   ),
     * @OA\Response(response=400, description="DATA_ERROR . Please try again or try another account & password",
     * content={
     *          @OA\MediaType(
     *              mediaType="application/json",
     *                 example=
     *                    {
     *                         "status": false,
     *                         "message": "DATA_ERROR . Please try again or try another account & password"
     *                   }
     *          )
     *       }),
     * )
     */

    public function login(Request $request)
    {

        $this->validate($request, [
            'account' => 'required|string',
            'password' => 'required|string',
        ]);

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
     * @OA\Post(
     *   tags={"UserAuth"},
     *   path="/user/resetPassword",
     *   summary="重製密碼 ( 需登入 )",
     *   security={{"user_token":{}}},
     *   @OA\RequestBody(
     *     @OA\MediaType(
     *          mediaType="multipart/form-data",
     *   @OA\Schema(
     *         required={"account","oldPassword","newPassword"},
     *         @OA\Property(property="account", type="string", description="帳號", example="account123"),
     *         @OA\Property(property="oldPassword", type="string", description="您的舊密碼", example="test123"),
     *         @OA\Property(property="newPassword", type="string", description="您的新密碼", example="newTest123"),
     *       )
     *     )
     *   ),
     *   @OA\Response(response=200, description="ResetPassword successful",
     *      content={
     *          @OA\MediaType(
     *              mediaType="application/json",
     *                 example=
     *                    {
     *                         "status" : true,
     *                         "message": "ResetPassword successful"
     *                   }
     *          )
     *       }
     *   ),
     * @OA\Response(response=400, description="Password reset failed , please try again",
     * content={
     *          @OA\MediaType(
     *              mediaType="application/json",
     *                 example=
     *                    {
     *                         "status" : false,
     *                         "message": "Password reset failed , please try again"
     *                   }
     *          )
     *       }),
     * @OA\Response(response=401, description="Unauthorized",
     * content={
     *          @OA\MediaType(
     *              mediaType="application/json",
     *                 example=
     *                    {
     *                         "message": "Token not provided"
     *                   }
     *          )
     *       })
     * )
     */

    public function resetPassword(Request $request)
    {
        $result = $this->UserAuthService->resetPassword($request);

        return $result;
    }

    /**
     * @OA\Post(
     *   tags={"UserAuth"},
     *   path="/user/logout",
     *   summary="身分登出 ( 需登入 )",
     *   security={{"user_token":{}}},
     *   @OA\Response(response=200, description="Successfully logged out.",
     *      content={
     *          @OA\MediaType(
     *              mediaType="application/json",
     *                 example=
     *                    {
     *                         "message": "Successfully logged out."
     *                   }
     *          )
     *       }
     *   ),
     * @OA\Response(response=401, description="Unauthorized",
     * content={
     *          @OA\MediaType(
     *              mediaType="application/json",
     *                 example=
     *                    {
     *                         "message": "Token not provided"
     *                   }
     *          )
     *       })
     * )
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
