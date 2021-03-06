<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\{AuthController, RegisterController};

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

Route::post('/auth/register', [RegisterController::class, 'store']);
Route::post('/auth/token', [AuthController::class, 'auth']);

Route::group([
    'middleware' => ['auth:sanctum'],
    'prefix' => 'auth',
    'namespace' => 'Auth',
], function () {

    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);
});
