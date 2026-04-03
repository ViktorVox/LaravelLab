<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
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

    public function index(Request $request)
    {
        $tasks = Task::where('user_id', $request->user()->id)->latest()->paginate(15);

        return TaskResource::collection($tasks)->additional([
            'status' => 'success'
        ]);
    }

    public function show(Request $request, Task $task)
    {
        Gate::authorize('view', $task);  

        return response()->json([
            'status'    => 'success',
            'data'      => new TaskResource($task)
        ]);
    }

    public function update(UpdateTaskRequest $request, Task $task)
    {
        Gate::authorize('update', $task);

        $task->update($request->validated());

        return response()->json([
            'status'    => 'success',
            'data'      => new TaskResource($task)
        ]);
    }

    public function destroy(Request $request, Task $task)
    {
        Gate::authorize('delete', $task);

        $task->delete();

        return response()->json([
            'status'    => 'success',
            'message'   => 'Задача удалена'
        ]);
    }
}
