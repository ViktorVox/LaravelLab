<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Jobs\ParsePostsJob;

class ParserController extends Controller
{   
    public function showPosts()
    {
        $posts = Post::all();

        return response()->json([
            'status'    => 'success',
            'data'      => $posts
        ]);
    }

    public function fetchPosts()
    {
        ParsePostsJob::dispatch();

        return response()->json([
            'status'    => 'success',
            'message'   => 'Парсинг запущен в фоновом режиме!'
        ]);
    }
}
