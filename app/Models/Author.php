<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Book;

class Author extends Model
{
    use HasFactory;
    // Разрешаем массовое заполнение
    protected $fillable = ['name', 'bio'];

    public function books()
    {
        return $this->hasMany(Book::class);
    }
}
