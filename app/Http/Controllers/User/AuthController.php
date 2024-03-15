<?php

namespace App\Http\Controllers\User;

use Mail;
use App\Models\User;
use App\Mail\RegisterMail;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use App\Http\Services\User\AuthService;
use App\Http\Services\User\UserService;
use App\Http\Requests\User\LoginUserRequest;
use App\Http\Requests\User\CreateUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Services\User\UpdateUserService;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Notifications\EmailUpdatedNotification;


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
    ){}

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
            'message'=>'User Created Successfully'
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
        $this->authService->login($request->all());
        return response()->json([
            "message" => "Please verify your email first"
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
        auth()->user()->tokens()->delete();
        return response()->json([
          "message"=>"logged out"
        ]);
    }

     
    
   
}
