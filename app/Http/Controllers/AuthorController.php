<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAuthorRequest;
use App\Http\Requests\UpdateAuthorRequest;
use App\Http\Resources\AuthorResource;
use App\Models\Author;

class AuthorController extends Controller
{
    public function index()
    {
        $authors = Author::with('books')->paginate(15);

        return AuthorResource::collection($authors)->additional([
            'status' => 'success'
        ]);
    }

    public function store(StoreAuthorRequest $request)
    {
        $validateData = $request->validated();

        $author = Author::create($validateData);

        return response()->json([
            'status'    => 'success',
            'data'      => new AuthorResource($author)
        ], 201);
    }

    public function show(Author $author)
    {
        $author->load('books');

        return response()->json([
            'status' => 'success',
            'author' => new AuthorResource($author) // Теперь возвращаем через Ресурс!
        ]);
    }

    public function update(UpdateAuthorRequest $request, Author $author)
    {
        $author->update($request->validated());

        return response()->json([
            'status'    => 'success',
            'data'      => new AuthorResource($author)
        ]);
    }

    public function destroy(Author $author)
    {
        $author->delete();

        return response()->json([
            'status'    => 'success',
            'message'   => 'Автор и его книги удалены'
        ]);
    }
}
