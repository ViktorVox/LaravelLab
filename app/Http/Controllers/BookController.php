<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookRequest;
use App\Http\Resources\BookResource;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function store(StoreBookRequest $request)
    {
        $validateData = $request->validated();

        $book = Book::create($validateData);

        return response()->json([
            'status'        => 'success',
            'data'          => new BookResource($book)
        ], 201);
    }
}
