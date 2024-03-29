<?php

namespace App\Http\Requests\User;

use App\Rules\PhoneNumberValidation;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'=>'required|string|max:30',
            'email'=>'required|string|email|unique:users',
            'password'=>'required|string|max:20|min:8',
            'age'=>'required|integer',
            'mobile' => ['required', new PhoneNumberValidation()]
        ];
    }
}
