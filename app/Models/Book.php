<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Author;

class Book extends Model
{
    use HasFactory;
    // Разрешаем массовое заполнение
    protected $fillable = ['title', 'publisher_year', 'author_id'];
    
    public function author()
    {
        return $this->belongsTo(Author::class);
    }
}
