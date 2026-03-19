<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Http\Requests\StoreTicketRequest;

class TicketController extends Controller
{
    // Клиент: Создать заявку
    public function store(StoreTicketRequest $request)
    {
        $ticket = $request->user()->tickets()->create([
            'subject' => $request->subject,
            'message' => $request->message,
            'status'  => 'new',     // По умолчанию новая
        ]);

        return response()->json([
            'status' => 'success',
            'data'   => $ticket
        ], 201);
    }

    // Клиент: Посмотреть СВОИ заявки
    public function userTickets(Request $request)
    {
        // Получаем только те заявки, которые принадлежат текущему юзеру
        $tickets = $request->user()->tickets()->latest()->get();

        return response()->json([
            'status' => 'success',
            'data'   => $tickets
        ]);
    }

    // Админ: Посмотреть ВСЕ заявки
    public function index()
    {
        // Не забываем жадную загрузку (with), чтобы сразу получить инфу о создателе
        $tickets = Ticket::with('user:id,name,email')->latest()->get();

        return response()->json([
            'status' => 'success',
            'data'   => $tickets
        ]);
    }

    // Админ: Изменить статус заявки
    public function updateStatus(Request $request, Ticket $ticket)
    {
        $request->validate([
            'status' => 'required|in:new,in_progress,resolved' // Жестко ограничиваем статусы
        ]);

        $ticket->update(['status' => $request->status]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Статус заявки обновлен!',
            'data'    => $ticket
        ]);
    }
}
