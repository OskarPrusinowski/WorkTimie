<?php

namespace App\Http\Requests\Applications;

use Illuminate\Foundation\Http\FormRequest;

class ConsiderApplication extends FormRequest
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
            'acceptationId' => 'required|integer',
            'status' => 'boolean',
        ];
    }
}
