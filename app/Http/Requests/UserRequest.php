<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Auth;
use App\User;

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
     * @return array
     */
    public function rules()
    {
        $user = $this->user;
        return [
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:25',Rule::unique('users')->ignore($user)],
            'avatar' => ['image'],
            'email' => ['required', 'string', 'email', 'max:255',Rule::unique('users')->ignore($user),]
        ];
    }
}
