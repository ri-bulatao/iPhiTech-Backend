<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CourseRequest extends FormRequest
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
            'title' => 'required|unique:courses',
        ];
    }

    /**
     * Error message for the field validations.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'title.required'    => 'Title is required',
            'title.unique'    => 'Title is already exist',
        ];
    }
}
