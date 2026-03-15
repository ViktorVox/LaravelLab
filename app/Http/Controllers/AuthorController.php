<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAuthorRequest;
use App\Http\Resources\AuthorResource;
use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
        //
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

    public function edit(Author $author)
    {
        //
    }

    public function update(Request $request, Author $author)
    {
        //
    }

    public function destroy(Author $author)
    {
        //
    }
}
