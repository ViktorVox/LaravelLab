<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Resources\TaskResource;

class TaskController extends Controller
{
    public function store(StoreTaskRequest $request)
    {
        // Берем ТОЛЬКО те данные, которые прошли валидацию
        $validateData = $request->validated();

        // Передаем валидированные данные в create
        $task = Task::create($validateData);

        return response()->json([
            'status'    => 'success',
            'data'      => $task
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
}
