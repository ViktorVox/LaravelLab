<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Http\Resources\BookResource;
use App\Models\Book;

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

    public function index()
    {
        $books = Book::with('author')->get();

        return response()->json([
            'status'    => 'success',
            'data'      => BookResource::collection($books)
        ]);
    }

    public function show(Book $book)
    {
        $book->load('author');

        return response()->json([
            'status'    => 'success',
            'data'      => new BookResource($book)
        ]);
    }

    public function update(UpdateBookRequest $request, Book $book)
    {
        $book->update($request->validated());

        return response()->json([
            'status'   => 'success',
            'data'     => new BookResource($book)
        ]);
    }

    public function destroy(Book $book)
    {
        $book->delete();

        return response()->json([
            'status'    => 'success',
            'message'   => 'Книга удалена'
        ]);
    }
}
