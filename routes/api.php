<?php

use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

// Регистрация
Route::post('/register', [AuthController::class, 'register']);

// Вход
Route::post('/login', [AuthController::class, 'login']);

// Защищенные маршруты
Route::middleware('auth:sanctum')->group(function () {
    // Создание задачи
    Route::post('/tasks', [TaskController::class, 'store']);

    // Чтение всех задач
    Route::get('/tasks', [TaskController::class, 'index']);

    // Чтение одной задачи по id
    Route::get('/tasks/{task}', [TaskController::class, 'show']);

    // Обновление задачи по id
    Route::put('/tasks/{task}', [TaskController::class, 'update']);

    // Удаление задачи по id
    Route::delete('/tasks/{task}', [TaskController::class, 'destroy']);

    // Выход с аккаунта
    Route::post('/logout', [AuthController::class, 'logout']);
});

// Создание автора
Route::post('/authors', [AuthorController::class, 'store']);

// Создание книги
Route::post('/books', [BookController::class, 'store']);

// Просмотр автора
Route::get('/authors/{author}', [AuthorController::class, 'show']);