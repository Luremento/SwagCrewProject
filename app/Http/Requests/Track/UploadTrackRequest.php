<?php

namespace App\Http\Requests\Track;

use Illuminate\Foundation\Http\FormRequest;

class UploadTrackRequest extends FormRequest
{
    /**
     * Правива валидации
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:100',
            'genre' => 'required|string|max:50',
            'audio_file' => 'required|file|mimes:mp3,wav,flac|max:20480', // 20MB
            'cover_image' => 'required|image|mimes:jpeg,png,webp|dimensions:min_width=500,min_height=500|max:5120', // 5MB
        ];
    }
}
