<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules() :array
    {
        return [
            'email' => 'required|email:rfc,dns|unique:users,email',
            'username' => 'required|unique:users,username',
            'password' => 'required|min:8',
            'password_confirmation' => 'required|same:password',
            
        ];
    }

    public function messages() :array
    {
        return [
            'email.required' => 'Please input a valid email',
            'email.unique' => 'An account already exists with this email. Login with your credentials.',
            'email.email' => 'Must be a valid email',
            'username.required' => 'Please input a valid username',
            'username.unique' => 'Please this username has been used ',
            'password.required' => 'Please input a valid password',
            'password.min' => 'Please your password should be 8 characters min ',
            'password_confirmation.required' => 'Please confirm password',
            'password_confirmation.same' => 'Please password do not match ',
        ];
    }
}
