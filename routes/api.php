<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
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

Route::get('/student', [StudentController::class, 'index']);
Route::post('/student', [StudentController::class, 'add']);
Route::put('/student/{id}', [StudentController::class, 'update']);
Route::get('/student/{id}', [StudentController::class, 'show']);
Route::delete('/student/{id}', [StudentController::class, 'delete']);


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
