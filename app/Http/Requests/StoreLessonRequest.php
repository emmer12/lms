<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLessonRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:100',
            'description'   => 'nullable|sometimes|string',
            'content_type'   => 'required|string',
            'duration'   => 'required|string',
            'sortOrder'   => 'required|numeric',
            'article_body'   => 'sometimes|string',
            'course_id'   => 'sometimes|string',
            'quiz_duration'   => 'sometimes',
            'quiz_type'   => 'sometimes',
            'preview'   => 'nullable|image|max:10240',

        ];
    }
}
