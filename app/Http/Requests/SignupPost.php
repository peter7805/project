<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SignupPost extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string',
            'account' => ['required', 'regex:/^[A-Z]{1}[0-9]{9}$/', 'unique:accounts'],
            'userId' => ['required', 'regex:/[a-zA-Z0-9]/', 'min:6', 'max:20'],
            'password' => ['required', 'regex:/[a-zA-Z0-9]/', 'min:6', 'max:20'],
        ];
    }
}
