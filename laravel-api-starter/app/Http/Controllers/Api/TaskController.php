<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * タスク一覧を取得
     */
    public function index()
    {
        $tasks = Task::where('user_id', 1)->get();

        return TaskResource::collection($tasks);
    }

    /**
     * タスクを作成
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
        ]);

        $data = array_merge($validated, [
            'user_id' => 1,
            'status' => 'pending',
        ]);

        $task = Task::create($data);

        return (new TaskResource($task))
            ->additional(['message' => 'タスクを作成しました'])
            ->response()
            ->setStatusCode(201);
    }

    /**
     * タスク詳細を取得
     */
    public function show(string $id)
    {
        $task = Task::where('user_id', 1)->find($id);

        if (! $task) {
            return response()->json([
                'message' => 'タスクが見つかりません',
                'error_code' => 'TASK_NOT_FOUND',
            ], 404);
        }

        return new TaskResource($task);
    }

    /**
     * タスクを更新
     */
    public function update(Request $request, string $id)
    {
        $task = Task::where('user_id', 1)->find($id);

        if (! $task) {
            return response()->json([
                'message' => 'タスクが見つかりません',
                'error_code' => 'TASK_NOT_FOUND',
            ], 404);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:pending,in_progress,completed',
            'due_date' => 'nullable|date',
        ]);

        $task->update($validated);

        return new TaskResource($task)
            ->additional(['message' => 'タスクを更新しました']);
    }

    /**
     * タスクを削除
     */
    public function destroy(string $id)
    {
        $task = Task::where('user_id', 1)->find($id);

        if (! $task) {
            return response()->json([
                'message' => 'タスクが見つかりません',
                'error_code' => 'TASK_NOT_FOUND',
            ], 404);
        }

        $task->delete();

        return response()->json(null, 204);
    }
}
