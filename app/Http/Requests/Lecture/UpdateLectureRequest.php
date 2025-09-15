<?php

namespace App\Http\Requests\Lecture;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLectureRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'topic' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string|max:1000',
        ];
    }

    public function messages(): array
    {
        return [
            'topic.required' => 'Поле тема лекции обязательно для заполнения',
            'topic.string' => 'Поле тема лекции должно быть строкой',
            'topic.max' => 'Поле тема лекции не должно превышать 255 символов',
            'description.required' => 'Поле описание лекции обязательно для заполнения',
            'description.string' => 'Поле описание лекции должно быть строкой',
            'description.max' => 'Поле описание лекции не должно превышать 1000 символов',
        ];
    }
}
