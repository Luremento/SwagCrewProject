<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'user_id', 'threads_id', 'track_id', 'content',
    ];

    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }
}
