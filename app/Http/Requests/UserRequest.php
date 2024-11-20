<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'role' => 'required',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|max:15',
            'password' => 'required|string|min:8',
        ];
    }

    public function messages()
    {
        return [
            'role.required' => 'Role seçiniz.',
            'name.required' => 'İsim alanı gereklidir.',
            'email.required' => 'Email alanı gereklidir.',
            'phone.required' => 'Telefon alanı gereklidir.',
            'password.required' => 'Şifre alanı gereklidir.',
        ];
    }
}
