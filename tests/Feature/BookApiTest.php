<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Book;
use App\Models\Author;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class BookApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_a_book(): void
    {
        $user = User::factory()->create();
        $author = Author::factory()->create();
        Sanctum::actingAs($user);

        $payload = [
            'author_id'         => $author->id,
            'title'             => 'Зеленая книга',
            'publisher_year'    => 1092
        ];
        
        $response = $this->postJson('api/books', $payload);
        $response->assertStatus(201);
        $this->assertDatabaseHas('books', ['title'  => 'Зеленая книга']);
    }

    public function test_user_can_get_all_books(): void
    {
        $user = User::factory()->create();
        $author = Author::factory()->create();
        Sanctum::actingAs($user);

        $books = Book::factory()->count(3)->create([
            'author_id'         => $author->id,
            'title'             => 'Книга',
            'publisher_year'    => 2000
        ]);

        $response = $this->getJson('api/books');
        $response
            ->assertStatus(200)
            ->assertJsonCount(3, 'data');

    }

    public function test_user_can_show_a_book(): void
    {
        $user = User::factory()->create();
        $author = Author::factory()->create();
        Sanctum::actingAs($user);

        $book = Book::factory()->create([
            'author_id'         => $author->id,
            'title'             => 'Название книги',
            'publisher_year'    => 2000
        ]);

        $response = $this->getJson('api/books/' . $book->id);
        $response
            ->assertStatus(200)
            ->assertJsonFragment(['title' => $book->title]);
    }

    public function test_user_can_update_a_book(): void
    {
        $user = User::factory()->create();
        $author = Author::factory()->create();
        Sanctum::actingAs($user);

        $book = Book::factory()->create([
            'author_id'         => $author->id,
            'title'             => 'Название книги',
            'publisher_year'    => 2000
        ]);

        $payload = [
            'author_id' => $author->id,
            'title'     => 'Новое Имя'
        ];

        $response = $this->putJson('api/books/' . $book->id, $payload);
        $response->assertStatus(200);

        $this->assertDatabaseHas('books', ['title' => 'Новое Имя']);
    }

    public function test_user_can_delete_a_book(): void
    {
        $user = User::factory()->create();
        $author = Author::factory()->create();
        Sanctum::actingAs($user);

        $book = Book::factory()->create([
            'author_id'         => $author->id,
            'title'             => 'Название книги',
            'publisher_year'    => 2000
        ]);

        $response = $this->delete('api/books/' . $book->id);
        $response->assertStatus(200);
        $this->assertDatabaseMissing('books', ['id' => $book->id]);
    }
}
