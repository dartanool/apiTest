<?php

namespace App\Http\Requests\Student;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateStudentRequest extends FormRequest
{

    /**
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $studentId = $this->route('student');

        return [
            'name' => ['sometimes', 'string', 'max:255'],
            'class_id' => ['sometimes', 'nullable', 'exists:classes,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.string' => 'Имя должно быть строкой.',
            'name.max' => 'Имя не должно превышать 255 символов.',
            'class_id.exists' => 'Выбранный класс не существует.',
        ];
    }
}

