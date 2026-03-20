<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

class AuthApiTest extends TestCase
{
    use RefreshDatabase;

    // Тест регистрации
    public function test_user_can_register(): void
    {
        $payload = [
            'name'      => 'user',
            'email'     => 'user@mail.com',
            'password'  => 'password123'
        ];

        $response = $this->postJson('/api/register', $payload);
        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'data' => [
                    'id',
                    'name',
                    'email'
                ],
                'token'
            ]);
        $this->assertDatabaseHas('users', ['name' => 'user']);
    }

    // Тест логина
    public function test_user_can_login(): void
    {
        $user = User::factory()->create();
        $payload = [
          'email'       => $user->email,
          'password'    => 'password'  
        ];

        $response = $this->postJson('/api/login', $payload);

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'data' => [
                    'id',
                    'name',
                    'email',
                ],
                'token'
            ]);
    }

    // Тест выхода
    public function test_user_can_logout(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        
        $response = $this->postJson('/api/logout');
        $response
            ->assertStatus(200)
            ->assertjsonFragment(['message' => 'Вы успешно вышли из системы']);
    }
}
