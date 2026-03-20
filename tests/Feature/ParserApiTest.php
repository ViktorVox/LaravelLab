<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class ParserApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_parser_fetch_posts(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        Http::fake([
            '*' => Http::response([
                [
                    'id'    => '1',
                    'title' => 'Тестовый заголовок',
                    'body'  => 'Тестовый текст поста'
                ]
            ], 200)
        ]);
        
        $response = $this->postJson('/api/parser/posts');
        $response->assertStatus(200);
        $this->assertDatabaseHas('posts', ['external_id' => '1', 'title' => 'Тестовый заголовок']);
    }

    public function test_parser_show_posts(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $response = $this->getJson('/api/parser/posts');
        $response->assertStatus(200);
    }
}
