<?php

namespace App\Http\Requests\Student;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreStudentRequest extends FormRequest
{
    /**
     * Получить правила валидации для запроса.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:students,email'],
            'class_id' => ['nullable', 'exists:classes,id'],
        ];
    }


    public function messages(): array
    {
        return [
            'name.required' => 'Имя студента обязательно для заполнения.',
            'name.string' => 'Имя должно быть строкой.',
            'name.max' => 'Имя не должно превышать 255 символов.',
            'email.required' => 'Email обязателен для заполнения.',
            'email.email' => 'Email должен быть действительным адресом электронной почты.',
            'email.unique' => 'Студент с таким email уже существует.',
            'class_id.exists' => 'Выбранный класс не существует.',
        ];
    }
}

