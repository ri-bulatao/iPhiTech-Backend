<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LeaveApplicationSaveRequest extends FormRequest
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
            'user_id' => 'required|integer',
            'type' => 'required|string',
            'from' => 'required',
            'to' => 'required',
            'reason' => 'required',
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'user_id.required' => 'The user id is required.',
            'user_id.integer' => 'Invalid format of the user id',
            'type.required' => 'The leave application type is required.',
            'type.string' => 'Invalid format of the leave type.',
            'from.required' => 'The request date from is required.',
            'to.required' => 'The request date to is required.',
            'reason.required' => 'The reason is required.',
        ];
    }
}
