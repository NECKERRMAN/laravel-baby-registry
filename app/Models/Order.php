<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    public function articles(){
        return $this->hasMany(Article::class);
    }

    public function registry(){
        return $this->belongsTo(Registry::class);
    }


    protected $casts = [
        'articles' => 'array'
    ];
}
