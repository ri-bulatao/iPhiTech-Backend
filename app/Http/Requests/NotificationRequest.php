<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NotificationRequest extends FormRequest
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
            'title' => 'required',
            'url' => 'required',
            'read' => 'required',
        ];
    }

    /**
     * Error messages.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'title.required' => 'The title field is required',
            'url.required'  => 'The URL field is required',
            'read.required' => 'The Read field is required',
        ];
    }
}
