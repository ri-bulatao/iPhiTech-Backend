<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AttendanceRequest extends FormRequest
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
            'user_id' => 'required|integer'
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'user_id.required' => 'The user id field is required.',
            'useR_id.integer' => 'The user id field have incorrect format.'
        ];
    }
}
