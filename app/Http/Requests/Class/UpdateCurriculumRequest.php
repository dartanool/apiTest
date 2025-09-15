<?php

namespace App\Http\Requests\Class;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCurriculumRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'lectures' => ['required', 'array', 'min:1'],
            'lectures.*.lecture_id' => ['required', 'exists:lectures,id'],
            'lectures.*.order' => ['required', 'integer', 'min:1'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'lectures.required' => 'Список лекций обязателен для заполнения.',
            'lectures.array' => 'Лекции должны быть переданы в виде массива.',
            'lectures.min' => 'Должна быть указана хотя бы одна лекция.',
            'lectures.*.lecture_id.required' => 'ID лекции обязателен для каждой записи.',
            'lectures.*.lecture_id.exists' => 'Указанная лекция не существует.',
            'lectures.*.order.required' => 'Порядок лекции обязателен для каждой записи.',
            'lectures.*.order.integer' => 'Порядок должен быть целым числом.',
            'lectures.*.order.min' => 'Порядок должен быть больше 0.',
        ];
    }
}

