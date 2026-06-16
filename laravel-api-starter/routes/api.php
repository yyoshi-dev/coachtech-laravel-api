<?php

use App\Http\Controllers\Api\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// 簡単なHello World API
Route::get('/hello', function () {
    return response()->json([
        'message' => 'Hello, World!',
    ]);
});

// パラメータを受け取るAPI
Route::get('/hello/{name}', function (string $name) {
    return response()->json([
        'message' => "Hello, {$name}!",
    ]);
});

// POSTリクエストを受け取るAPI
Route::post('/echo', function (Request $request) {
    return response()->json([
        'received' => $request->input('message'),
    ]);
});

Route::apiResource('tasks', TaskController::class);
