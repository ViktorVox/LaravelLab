<?php

namespace App\Jobs;

use App\Events\PostsParsed;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Http;
use App\Models\Post;

class ParsePostsJob implements ShouldQueue
{
    use Queueable;

    public function __construct()
    {
        //
    }

    public function handle(): void
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

        event(new PostsParsed('Парсинг завершён, 10 постов в базе!'));
    }
}
