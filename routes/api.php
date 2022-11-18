<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProblemSolvingController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::prefix('users')->group(function () {
    Route::get('', [UserController::class, 'users']);
    Route::get('user', [UserController::class, 'user']);
    Route::put('update', [UserController::class, 'update']);
    Route::delete('delete', [UserController::class, 'delete']);
});

Route::get('problem-one', [ProblemSolvingController::class, 'problemOne']);
Route::get('problem-two', [ProblemSolvingController::class, 'problemTwo']);
Route::get('problem-three', [ProblemSolvingController::class, 'problemThree']);
