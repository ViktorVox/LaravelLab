<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Author;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AuthorApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_create_author(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $payload = [
            'name'  => 'Писатель',
            'bio'   => 'Он прекрасный автор'
        ];

        $response = $this->postJson('api/authors', $payload);
        $response
            ->assertStatus(201)
            ->assertJsonFragment(['name' => 'Писатель']);
    }

    public function test_user_can_get_all_authors(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $authors = Author::factory()->count(2)->create([
            'name'  => 'Писатель'
        ]);

        $response = $this->getJson('api/authors');
        $response
            ->assertStatus(200)
            ->assertJsonCount(2, 'data');
    }

    public function test_user_can_show_a_author(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $author = Author::factory()->create([
            'name' => 'Автор'
        ]);

        $response = $this->getJson('api/authors/' . $author->id);
        $response
            ->assertStatus(200)
            ->assertJsonFragment(['name' => $author->name]);
    }
    
    public function test_user_can_update_a_author(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $author = Author::factory()->create([
            'name'   => 'Автор'
        ]);

        $payload = [
            'name'  => 'Сунь Цзи',
            'bio'   => 'Какая-то биография'
        ];
        
        $response = $this->putJson('api/authors/' . $author->id, $payload);
        $response->assertStatus(200);

        $this->assertDatabaseHas('authors', ['name' => 'Сунь Цзи']);
    }

    public function test_user_can_delete_a_author(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $author = Author::factory()->create([
            'name' => 'Имя'
        ]);

        $response = $this->delete('api/authors/' . $author->id);
        $response->assertStatus(200);
        $this->assertDatabaseMissing('authors', ['id' => $author->id]);
    }
}
