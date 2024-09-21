<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReservationRequest extends FormRequest
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
            'date' => 'required',
            'time' => 'required',
            'number' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'date.required' => '日付は必ず指定してください',
            'time.required' => '時間は必ず指定してください',
            'number.required' => '人数は必ず指定してください',
        ];
    }
}
