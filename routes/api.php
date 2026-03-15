<?php

use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

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

// Регистрация
Route::post('/register', [AuthController::class, 'register']);

// Вход
Route::post('/login', [AuthController::class, 'login']);