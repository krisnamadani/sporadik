<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        if($this->isMethod('post')) {
            return  [
                'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,heic|max:4096',
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|confirmed|min:6',
            ];
        } else {
            return  [
                'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,heic|max:4096',
                'name' => 'required',
                'email' => 'required|email|unique:users,email,'.$this->id,
                'password' => 'nullable|confirmed|min:6',
            ];
        }
    }
}
