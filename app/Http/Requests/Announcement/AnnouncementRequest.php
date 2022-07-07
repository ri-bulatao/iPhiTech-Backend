<?php

declare(strict_types=1);

namespace App\Http\Requests\Announcement;

use Illuminate\Foundation\Http\FormRequest;

class AnnouncementRequest extends FormRequest
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
            'title' => 'required|unique:announcements',
            'excerpt'   => 'required',
            'content'  => 'required|min:8',
            'receiver'  => 'required',
        ];
    }

    public function messages()
    {
        return [
            'title.required'    => 'Title is required',
            'title.unique'      => 'Title already taken',
            'excerpt.required'  => 'Excerpt is required',
            'content.required'  => 'Content are required',
            'receiver.required' => 'Receiver is required',
        ];
    }
}
