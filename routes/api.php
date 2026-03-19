<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\ParserController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TicketController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);                  // Регистрация
Route::post('/login', [AuthController::class, 'login']);                        // Вход

// Защищенные маршруты
Route::middleware('auth:sanctum')->group(function () {
    // Маршруты задач
    Route::post('/tasks', [TaskController::class, 'store']);                    // Создание задачи
    Route::get('/tasks', [TaskController::class, 'index']);                     // Чтение всех задач
    Route::get('/tasks/{task}', [TaskController::class, 'show']);               // Чтение одной задачи по id
    Route::put('/tasks/{task}', [TaskController::class, 'update']);             // Обновление задачи по id
    Route::delete('/tasks/{task}', [TaskController::class, 'destroy']);         // Удаление задачи по id

    // Маршруты кинг
    Route::post('/books', [BookController::class, 'store']);                    // Создание книги
    Route::get('/books', [BookController::class, 'index']);                     // Информация о всех книгах
    Route::get('/books/{book}', [BookController::class, 'show']);               // Информация о книге по id
    Route::put('/books/{book}', [BookController::class, 'update']);             // Обновление информации о книге по id
    Route::delete('/books/{book}', [BookController::class, 'destroy']);         // Удаление книги по id

    // Маршруты авторов
    Route::post('/authors', [AuthorController::class, 'store']);                // Создание автора
    Route::get('/authors', [AuthorController::class, 'index']);                 // Информация о всех авторах
    Route::get('/authors/{author}', [AuthorController::class, 'show']);         // Информация об авторе по id
    Route::put('/authors/{author}', [AuthorController::class, 'update']);       // Обновление информации об авторе по id
    Route::delete('/authors/{author}', [AuthorController::class, 'destroy']);   // Удаление автора и его книг по id

    // Аутенфикация
    Route::post('/logout', [AuthController::class, 'logout']);                  // Выход с аккаунта

    // Парсер постов
    Route::post('/parser/posts', [ParserController::class, 'fetchPosts']);      // Подгрузить посты
    Route::get('/parser/posts', [ParserController::class, 'showPosts']);        // Показать посты

    // CRM: Клиентская часть
    Route::post('/tickets', [TicketController::class, 'store']);                // Создать заявку
    Route::get('/tickets/my', [TicketController::class, 'userTickets']);        // Посмотреть СВОИ заявки
    
    // CRM: Админская часть
    Route::middleware('admin')->group(function () {
        Route::get('/tickets', [TicketController::class, 'index']);                     // Посмотреть ВСЕ заявки
        Route::patch('/tickets/{ticket}/status', [TicketController::class, 'updateStatus']);  // Изменить статус
    });

});