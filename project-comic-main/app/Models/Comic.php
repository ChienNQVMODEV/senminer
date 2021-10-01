<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comic extends Model
{
    protected $fillable = [
        'avatar',
        'name',
        'author',
        'status',
        'category',
        'trailer',
        'comic_link',
        'id_check'
    ];

    public function chapters()
    {
        return $this->hasMany(Chapter::class, 'comic_id');
    }
}
