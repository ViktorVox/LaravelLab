<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    // Разрешаем массовое заполнение
    protected $fillable = ['title', 'publisher_year', 'author_id'];
}
