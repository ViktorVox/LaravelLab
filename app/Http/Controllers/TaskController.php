<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Http\Requests\StoreTaskRequest;

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
}
