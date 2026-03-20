<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resources\TaskResource;

class TaskController extends Controller
{
    public function store(StoreTaskRequest $request)
    {
        // Берем ТОЛЬКО те данные, которые прошли валидацию
        $validatedData = $request->validated();

        // Добавляем ID текущего пользователя из токена
        $validatedData['user_id'] = $request->user()->id;

        // Передаем валидированные данные в create
        $task = Task::create($validatedData);

        return response()->json([
            'status'    => 'success',
            'data'      => new TaskResource($task)
        ], 201);
    }

    public function index()
    {
        $tasks = Task::all();

        return response()->json([
            'status'    => 'success',
            'data'      => TaskResource::collection($tasks)
        ]);
    }

    public function show(Task $task)
    {
        return response()->json([
            'status'    => 'success',
            'data'      => new TaskResource($task)
        ]);
    }

    public function update(UpdateTaskRequest $request, Task $task)
    {
        $task->update($request->validated());

        return response()->json([
            'status'    => 'success',
            'data'      => new TaskResource($task)
        ]);
    }

    public function destroy(Task $task)
    {
        $task->delete();

        return response()->json([
            'status'    => 'success',
            'message'   => 'Задача удалена'
        ]);
    }
}
