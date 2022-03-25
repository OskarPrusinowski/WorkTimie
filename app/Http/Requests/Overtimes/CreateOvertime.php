<?php

namespace App\Http\Requests\Overtimes;

use Illuminate\Foundation\Http\FormRequest;

class CreateOvertime extends FormRequest
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
            'overtime.minutes' => 'required|integer',
            'overtime.date' => 'required|date',
            'overtime.user_id' => 'required|integer',
        ];
    }
}
