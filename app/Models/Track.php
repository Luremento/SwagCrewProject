<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Track extends Model
{
    use SoftDeletes, HasFactory;
    protected $fillable = [
        'user_id',
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
     * Получить файлы трека через полиморфную связь
     */
    public function files()
    {
        return $this->morphMany(\App\Models\File::class, 'fileable');
    }


    /**
     * Получить основной аудио файл трека
     */
    public function audioFile()
    {
        return $this->files()->where('path', 'like', 'tracks/%')->first();
    }

    public function comments()
    {
        return $this->hasMany(Comment::class)->latest();
    }

    /**
     * Получить жанр трека
     */
    public function genre()
    {
        return $this->belongsTo(Genre::class);
    }

    /**
     * The playlists that contain this track.
     */
    public function playlists(): BelongsToMany
    {
        return $this->belongsToMany(Playlist::class)
            ->withPivot('position')
            ->withTimestamps();
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }
}