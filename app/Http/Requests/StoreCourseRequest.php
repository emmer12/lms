<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCourseRequest extends FormRequest
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
            'duration'   => 'sometimes|string',
            'published'   => 'sometimes|boolean',
            // 'preview'   => 'required|image|max:10240',
            'preview' => $this->request->has('preview') ? 'nullable' : 'image|max:10240',
            'featured'   => 'sometimes',
        ];
    }
}
