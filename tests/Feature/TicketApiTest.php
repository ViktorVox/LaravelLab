<?php

namespace Tests\Feature;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class TicketApiTest extends TestCase
{
    use RefreshDatabase;

    // CRM: Клиентская часть
    public function test_user_create_ticket(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $payload = [
            'subject'   =>  'Создай тесты',
            'message'   =>  'Осталось совсем чуть-чуть, всего 3 пути'
        ];

        $response = $this->postJson('/api/tickets', $payload);
        $response->assertStatus(201);
        $this->assertDatabaseHas('tickets', ['subject' => 'Создай тесты']);
    }

    public function test_user_can_view_only_their_own_tickets(): void
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        Sanctum::actingAs($user);

        $tickets = Ticket::factory()->count(2)->create([
            'user_id'   => $user->id
        ]);
        
        $ticket = Ticket::factory()->create([
            'user_id'   => $otherUser->id
        ]);

        $response = $this->getJson('/api/tickets/my');
        $response->assertJsonCount(2, 'data');
    }

    // CRM: Админская часть
    public function test_regular_user_cannot_view_all_tickets(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $response = $this->getJson('/api/tickets');
        $response->assertStatus(403);
    }

    public function test_admin_can_view_all_tickets(): void
    {
        $user = User::factory()->create([
            'role'  => 'admin'
        ]);
        Sanctum::actingAs($user);

        $response = $this->getJson('/api/tickets');
        $response->assertStatus(200);
    }

    public function test_regular_user_cannot_change_status_for_ticket(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $ticket = Ticket::factory()->create([
            'user_id'   =>  $user->id,
            'subject'   =>  'Задача',
            'message'   =>  'Сделай'
        ]);
        
        $payload = [
            'status' => 'in_progress'
        ];

        $response = $this->patchJson('/api/tickets/' . $ticket->id . '/status', $payload);
        $response->assertStatus(403);
    }

    public function test_admin_can_change_status_for_ticket(): void
    {
        $user = User::factory()->create([
            'role' => 'admin'
        ]);
        Sanctum::actingAs($user);

        $ticket = Ticket::factory()->create([
            'user_id'   =>  $user->id,
            'subject'   =>  'Задача',
            'message'   =>  'Сделай'
        ]);
        
        $payload = [
            'status' => 'in_progress'
        ];

        $response = $this->patchJson('/api/tickets/' . $ticket->id . '/status', $payload);
        $response
            ->assertStatus(200)
            ->assertJsonFragment(['message' => 'Статус заявки обновлен!']);
        $this->assertDatabaseHas('tickets', ['status' => 'in_progress']);
    }
}
