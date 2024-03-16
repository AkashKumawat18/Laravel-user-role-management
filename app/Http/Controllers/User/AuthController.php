<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Services\User\AuthService;
use App\Http\Services\User\UserService;
use App\Http\Requests\User\LoginUserRequest;
use App\Http\Requests\User\CreateUserRequest;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * AuthController constructor
     * 
     * @param AuthService $authService
     * @param UserService $userService
     */
    public function __construct(
        protected AuthService $authService,
        protected UserService $userService,
    ) {
    }

    /**
     * Register user
     * 
     * @param CreateUserRequest $request
     * 
     * @return JsonResponse
     */
    public function register(CreateUserRequest $request): JsonResponse
    {
        $this->authService->create(data: $request->all());

        return response()->json([
            'message' => 'User Created Successfully'
        ]);
    }

    /**
     * Login user
     * 
     * @param LoginUserRequest $request
     * 
     * @return JsonResponse
     */
    public function login(LoginUserRequest $request): JsonResponse
    {

        $token = $this->authService->login($request->all());
        return response()->json([
            'access_token' => $token,
        ]);
    }

    /**
     * Logout user
     * @param
     * 
     * @return JsonResponse
     */

    public function logout(): JsonResponse
    {
        Auth::logout(auth()->user());
        return response()->json([
            "message" => "logged out"
        ]);
    }
}
