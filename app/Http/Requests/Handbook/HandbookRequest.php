<?php

declare(strict_types=1);

namespace App\Http\Requests\Handbook;

use Illuminate\Foundation\Http\FormRequest;

class HandbookRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'version_name' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'version_name.required'    => 'Name is required',
        ];
    }
}
