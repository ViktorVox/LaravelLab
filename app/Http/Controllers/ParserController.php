<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Support\Facades\Http;

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
        $response = Http::get('https://jsonplaceholder.typicode.com/posts');
        $posts = $response->json();

        $topPosts = collect($posts)->take(10);

        foreach ($topPosts as $post) {
            Post::updateOrCreate(
                ['external_id' => $post['id']],
                [
                    'title' => $post['title'],
                    'body'  => $post['body']
                ]
            );
        }

        return response()->json([
            'status'    => 'success',
            'message'   => 'Парсинг запущен в фоновом режиме!'
        ]);
    }
}
