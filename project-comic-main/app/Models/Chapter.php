<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
    protected $casts = [
        'content' => 'array'
    ];

    protected $fillable = [
        'comic_id',
        'order',
        'content'
    ];

    public function comic()
    {
        return $this->belongsTo(Comic::class, 'comic_id');
    }
}
