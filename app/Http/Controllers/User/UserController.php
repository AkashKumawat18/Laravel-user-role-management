<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\ForgotPasswordMail;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Mail;
use App\Http\Resources\UserCollection;
use App\Http\Services\User\UserService;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Requests\User\ResetPasswordRequest;
use App\Http\Requests\User\ForgetPasswordRequest;

class UserController extends Controller
{
    /**
     * UserController constructor
     * 
     * @param UserService $userService
     */
    public function __construct(
        protected UserService $userService,
    ){
    }

     /**
     * Get all users
     * 
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $users = $this->userService->getAllUsers($request);

        return response()->json([new UserCollection($users)]);
    }

    /**
     * Delete a user
     * 
     * @return JsonResponse
     */
    public function delete($id) :JsonResponse
    {
        $user = $this->userService->getByIdOrFail($id);

        $user->delete();

        return response()->json([
            "users"=>"User has been deleted successfully ",
        ]);
    }

    /**
     * Update user
     * 
     *  @param UpdateUserRequest $request
     * 
     * @return JsonResponse
     */
    public function update(int $id, UpdateUserRequest $request) : JsonResponse
    {
        $user = $this->userService->getByIdOrFail($id);

        $user = $this->userService->update(user: $user, data: $request->all());

        return response()->json([
            'data' => new UserResource($user)
        ]);
    }

     /**
     * Verify user
     * 
     *  @param UpdateUserRequest $request
     * 
     * @return JsonResponse
     */
    public function verify($token)
    {
        $user = $this->userService->getByRememberTokenOrFail($token);

        $this->userService->verify(user: $user);

        return response()->json([
            'message'=> "Your account has been successfully verified"
        ]);
    }

    /**
     * forget password
     * 
     *  @param ForgetPasswordRequest $request
     * 
     * @return JsonResponse
     */

     public function forgot(ForgetPasswordRequest $request):JsonResponse
     {
        $user = $this->userService->getByEmailOrFail($request->email);

            
        $this->userService->forgot(user: $user);

        return response()->json([
            "Message"=>"Please check your email and reset your password"
        ]);
     }

    /**
     * reset password
     * 
     *  @param ForgetPasswordRequest $request
     * 
     * @return JsonResponse
     */

     public function reset(string $token, ResetPasswordRequest $request):JsonResponse
     {        
        $user = $this->userService->getByRememberTokenOrFail($token);

        $user =  $this->userService->resetPassword(user: $user, data: $request->all());

        return response()->json([
            "message"=>"Your password has been successfully updated",
            "User"=>$user
        ]);
     }
}
