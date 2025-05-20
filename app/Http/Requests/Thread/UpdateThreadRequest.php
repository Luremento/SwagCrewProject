<?php

namespace App\Http\Requests\Thread;

use Illuminate\Foundation\Http\FormRequest;

class UpdateThreadRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|min:5|max:255',
            'category' => 'required|exists:categories,id',
            'tags' => 'nullable|string|max:255',
            'content' => 'required|string|min:10',
            'attached_track_id' => 'nullable|exists:tracks,id',
            'files.*' => 'nullable|file|max:10240',
            'delete_files' => 'nullable|array',
            'delete_files.*' => 'exists:files,id',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'title.required' => 'Пожалуйста, введите заголовок темы',
            'title.min' => 'Заголовок темы должен содержать не менее 5 символов',
            'title.max' => 'Заголовок темы не должен превышать 255 символов',
            'category.required' => 'Пожалуйста, выберите категорию',
            'category.exists' => 'Выбранная категория не существует',
            'tags.max' => 'Список тегов не должен превышать 255 символов',
            'content.required' => 'Пожалуйста, введите содержание темы',
            'content.min' => 'Содержание темы должно содержать не менее 10 символов',
            'attached_track_id.exists' => 'Выбранный трек не существует',
            'files.*.max' => 'Размер файла не должен превышать 10 МБ',
            'files.*.file' => 'Загруженный файл должен быть файлом',
            'delete_files.*.exists' => 'Выбранный для удаления файл не существует',
        ];
    }
}
