<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tags extends Model
{
    protected $fillable = [
        'name',
    ];

    public function threads()
    {
        return $this->belongsToMany(Thread::class, 'tag_thread', 'tag_id', 'thread_id');
    }
}
