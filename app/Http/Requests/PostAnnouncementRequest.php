<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostAnnouncementRequest extends FormRequest
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
            'id'        => 'required|integer',
            'status'    => 'required|string'
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'id.required'           => 'The ID field is required',
            'id.integer'            => 'Passed an invalid ID format',
            'status.required'       => 'The status is required'
        ];
    }
}
