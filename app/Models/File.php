<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $fillable = [
        'original_name',
        'path',
        'hash',
        'size',
        'fileable_id',
        'fileable_type',
    ];

    public function track()
    {
        return $this->hasOne(Track::class);
    }

    public function fileable()
    {
        return $this->morphTo();
    }
}
