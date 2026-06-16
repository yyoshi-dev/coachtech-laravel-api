<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'data' => [
                ['id' => 1, 'title' => 'タスク1'],
                ['id' => 2, 'title' => 'タスク2'],
            ],
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // リクエストの内容をログに出力
        Log::info('タスク作成リクエスト', [
            'title' => $request->input('title'),
            'description' => $request->input('description'),
        ]);

        return response()->json([
            'message' => 'タスクを作成しました',
            'data' => [
                'id' => 3,
                'title' => $request->input('title'),
            ],
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return response()->json([
            'data' => [
                'id' => $id,
                'title' => "タスク{$id}",
            ],
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        return response()->json([
            'message' => 'タスクを更新しました',
            'data' => [
                'id' => $id,
                'title' => $request->input('title'),
            ],
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return response()->json(null, 204);
    }
}
