<?php

namespace App\Http\Requests\AdditionalHours;

use Illuminate\Foundation\Http\FormRequest;

class CreateAdditionalHour extends FormRequest
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
            'additionalHour.minutes' => 'required|integer',
            'additionalHour.date' => 'required|date',
            'additionalHour.user_id' => 'required|integer',
        ];
    }
}
