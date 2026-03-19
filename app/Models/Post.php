<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    // Разрешаем массовое заполнение
    protected $fillable = ['external_id', 'title', 'body'];
}
