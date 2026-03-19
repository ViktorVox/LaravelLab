<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Http;
use App\Models\Post;

class ParsePostsJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
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
    }
}
