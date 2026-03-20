<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class TaskApiTest extends TestCase
{
    use RefreshDatabase;

    // Тест по созданию задачи
    public function test_user_can_create_a_task(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $payload = [
            'title'         => 'Авто-тест',
            'description'   => 'Проводится тест по созданию заметки...'
        ];

        $response = $this->postJson('api/tasks', $payload);
        $response->assertStatus(201);
        $this->assertDatabaseHas('tasks', ['title' => 'Авто-тест']);
    }

    // Тест по получению всех задач
    public function test_user_can_get_all_tasks(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $tasks = Task::factory()->count(3)->create([
            'user_id' => $user->id
        ]);

        $response = $this->getJson('api/tasks');
        $response
            ->assertStatus(200)
            ->assertJsonCount(3, 'data');
    }

    // Тест по получению конкретной задачи
    public function test_user_can_show_a_task(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $task = Task::factory()->create([
            'user_id' => $user->id
        ]);

        $response = $this->getJson('api/tasks/' . $task->id);
        $response
            ->assertStatus(200)
            ->assertJsonFragment(['title' => $task->title]);
    }

    // Тест по обновлению конкретной задачи
    public function test_user_can_update_a_task(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $task = Task::factory()->create([
            'user_id'   => $user->id
        ]);

        $payload = [
            'title'         => 'Обновленная задача',
            'description'   => 'Тест обновления задачи'
        ];
        
        $response = $this->putJson('api/tasks/' . $task->id, $payload);
        $response->assertStatus(200);

        $this->assertDatabaseHas('tasks', ['title' => 'Обновленная задача']);
    }

    // Тест по удалению конкретной задачи
    public function test_user_can_delete_a_task(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $task = Task::factory()->create([
            'user_id' => $user->id
        ]);

        $response = $this->deleteJson('api/tasks/' . $task->id);
        $response->assertStatus(200);
        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }
}
