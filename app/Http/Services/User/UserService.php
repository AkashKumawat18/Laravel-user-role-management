<?php

namespace App\Http\Services\User;

use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\ForgotPasswordMail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use GuzzleHttp\Exception\ClientException;

class UserService
{
    /**
     * Get all users
     *
     * @param Request $request
     * @return ?LengthAwarePaginator
     */
    public function getAllUsers(Request $request): ?LengthAwarePaginator
    {
        return User::query()
            ->when($request->input('q_search'), function($query) use($request){
                return $query->whereAny(['name', 'email', 'mobile'], $request->input('q_search'));
            })->paginate(10, ['*'], 'page', $request->input('page', 1));
    }


    /**
     * Get user using id(if not found throw exception)
     *
     * @param int $id
     *
     * @return ?User
     */
    public function getByIdOrFail(int $id)
    {
        return User::findOrFail($id);
    }

    /**
     * Get user using id(if not found throw exception)
     *
     * @param string $email
     *
     * @return ?User
     */
    public function getByEmailOrFail(string $email)
    {
        return User::where('email', $email)->firstOrFail();
    }

    /**
     * Get user using token(if not found throw exception)
     *
     * @param string $token
     *
     * @return ?User
     */
    public function getByRememberTokenOrFail(string $token)
    {

        return User::where('remember_token',$token)->firstOrFail();
    }

    /**
     * Update an user
     *
     * @param User $user
     * @param array $data
     *
     * @return User
     */
    public function update(User $user, array $data): User
    {
        /** @var User $user */
        $user = tap($user)->update([
            'name' => $data['name'],
            'email' => $data['email'],
            'mobile' => $data['mobile'],
            'age' => $data['age'],
        ]);

        $user->role()->sync([$data['role_id']]);

        return $user;
    }



     /**
     * Verify an user
     *
     * @param User $user
     *
     * @return User
     */
    public function verify(User $user): User
    {
        $user->email_verified_at = now();
        $user->remember_token = null;
        $user->save();
        return $user;
    }

      /**
     * forgot password
     *
     * @param User $user
     *
     * @return User
     */
    public function forgot(User $user): User
    {
        $user->remember_token =  Str::random(40);

        $user->save();
           //send mail verification
        Mail::to($user->email)->send(new ForgotPasswordMail(user: $user));

        return $user;
    }

      /**
     * reset password
     *
     * @param $token
     * @param User $user
     *
     * @return User
     */
    public function resetPassword(User $user, array $data): User
    {
        $user->password = $data['password'];
        $user->remember_token = null;
        $user->save();

        return $user;
    }
}
