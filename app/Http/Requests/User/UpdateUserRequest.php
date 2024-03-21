<?php

namespace App\Http\Requests\User;

use Illuminate\Validation\Rule;
use App\Rules\PhoneNumberValidation;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return !empty(auth()->user());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'=>['required', 'string', 'max:30'],
            'email'=> ['required', 'email', 'max:50', Rule::unique('users')->ignore($this->id)],
            'age'=>['required', 'integer'],
            'mobile' => ['required', new PhoneNumberValidation()],
            'role_id' => ['required', 'integer', 'exists:roles,id']
        ];
    }
}
