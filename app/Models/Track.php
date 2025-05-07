<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Track extends Model
{
    protected $fillable = [
        'user_id',
        'file_id',
        'genre_id',
        'title',
        'cover_image',
    ];

    /**
     * Получить пользователя, которому принадлежит трек
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Получить файл трека
     */
    public function file()
    {
        return $this->belongsTo(File::class);
    }

    /**
     * Получить жанр трека
     */
    public function genre()
    {
        return $this->belongsTo(Genre::class);
    }
}
