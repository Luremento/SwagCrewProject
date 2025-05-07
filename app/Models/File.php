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
    ];

    public function track()
    {
        return $this->hasOne(Track::class);
    }
}
