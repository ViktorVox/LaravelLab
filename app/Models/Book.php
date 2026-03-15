<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Author;

class Book extends Model
{
    // Разрешаем массовое заполнение
    protected $fillable = ['title', 'publisher_year', 'author_id'];
    
    public function author()
    {
        return $this->belongsTo(Author::class);
    }
}
