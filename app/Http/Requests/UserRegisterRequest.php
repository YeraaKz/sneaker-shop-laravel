<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class UserRegisterRequest extends FormRequest
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
    public function rules(): array
    {
        return [
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|string|email|min:6|unique:users',
            'password' => 'required|string|min:6'
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new \HttpResponseException(response()->json([
            'message' => 'Validation Error',
            'errors' => $validator->errors()
        ]), 500);
    }
}
