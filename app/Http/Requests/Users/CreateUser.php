<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;

class CreateUser extends FormRequest
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
            'user.name' => 'required|string|min:3|max:20',
            'user.surname' => 'required|string|min:3|max:20',
            'user.email' => 'required|email|unique:users,email',
            'user.date_start_employment' => 'required|date',
            'user.counter_holidays' => 'integer',
            'user.password' => 'required|string|min:8|max:20',
            'user.group_id' => 'required|integer',
            'user.department_id' => 'required|integer',
        ];
    }
}
