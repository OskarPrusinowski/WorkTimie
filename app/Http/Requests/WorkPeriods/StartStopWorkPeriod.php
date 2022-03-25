<?php

namespace App\Http\Requests\WorkPeriods;

use Illuminate\Foundation\Http\FormRequest;

class StartStopWorkPeriod extends FormRequest
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
            'workPeriod.type' => 'required|string',
            'workPeriod.is_private' => 'required|boolean',
            'workPeriod.workday_id' => 'required|integer',
        ];
    }
}
