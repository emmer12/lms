<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCourseRequest extends FormRequest
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
            'price'   => 'sometimes|required|numeric',
            'description'   => 'sometimes|string',
            'duration'   => 'sometimes|numeric',
            'published'   => 'sometimes|boolean',
            'preview'   => 'sometimes|image|max:10240',
        ];
    }
}
