<?php

namespace App\Http\Services\User;

use App\Models\User;
use App\Mail\RegisterMail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Http\Services\User\UserService;


class AuthService
{
    /**
     * AuthService Constructor
     * 
     * @param UserService $userService
     */
    public function __construct(
        protected UserService $userService,
    ){}

    /**
     * Create the user
     * 
     * @param array $data
     * 
     * @return Void
     */
    public function create(array $data): void
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
            'mobile'=> $data['mobile'],
            'age'=> $data['age'],
            'remember_token' => Str::random(40),
        ]); 

        // Send verification mail
        Mail::to($user->email)->send(new RegisterMail(user: $user));
    }

    public function login(array $data)
    {
        if(!Auth::attempt(['email' => $data['email'], 'password' => $data['password']])){
            return response()->json(['message'=>'Invalid login details'], 401);
        }

        $user = $this->userService->getByEmailOrFail($data['email']);

        if(empty($user->email_verified_at)){
            throw new ClientException('Your email verification is pending');
        }

        Auth::login($user);

        dd(auth()->user()->access_token);
    }
}