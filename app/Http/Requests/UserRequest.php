<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'first_name' => 'required',
            'last_name' => 'required',
            // 'new_password' => 'min:6|max:100',
        ];
    }

    public function messages()
    {
        return [
            'first_name.required'    => 'First Name is required!',
            'last_name.required'      => 'Last Name is required!',
            'name.min'      => 'Minimum 8 characters!',
        ];
    }
}
