<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use HasFactory;

    /**
     * Атрибуты, которые можно массово назначать.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'track_id',
    ];

    /**
     * Получить пользователя, которому принадлежит избранное.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Получить трек, который находится в избранном.
     */
    public function track()
    {
        return $this->belongsTo(Track::class);
    }
}