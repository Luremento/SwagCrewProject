<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    protected $fillable = [
        'user_id', 'category_id', 'track_id', 'title', 'content',
    ];

    public function tags()
    {
        return $this->belongsToMany(Tags::class, 'tag_thread', 'thread_id', 'tag_id');
    }

    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function track()
    {
        return $this->belongsTo(Track::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'thread_id');
    }
}
