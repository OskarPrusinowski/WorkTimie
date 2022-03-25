<?php

namespace App\Http\Requests\WorkDays;

use Illuminate\Foundation\Http\FormRequest;

class StartWorkDay extends FormRequest
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
            'userId' => 'required|integer',
            'defaultWorktime' => 'required|integer',
        ];
    }
}
