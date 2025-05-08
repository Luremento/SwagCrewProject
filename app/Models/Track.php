<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Track extends Model
{
    protected $fillable = [
        'user_id', 'genre_id', 'title', 'cover_image',
    ];

    /**
     * Получить пользователя, которому принадлежит трек
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Получить файлы трека через полиморфную связь
     */
    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }

    /**
     * Получить основной аудио файл трека
     */
    public function audioFile()
    {
        return $this->files()->where('path', 'like', 'tracks/%')->first();
    }

    /**
     * Получить жанр трека
     */
    public function genre()
    {
        return $this->belongsTo(Genre::class);
    }
}
