<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'user_id', 'thread_id', 'track_id', 'content',
    ];

    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }

    public function thread()
    {
        return $this->belongsTo(Thread::class, 'thread_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function track()
    {
        return $this->belongsTo(Track::class);
    }
}
