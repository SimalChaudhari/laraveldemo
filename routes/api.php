<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\UserController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('api')->post('create_hipaa_mart_portal_user_api', [App\Http\Controllers\ApiController::class, '_api_create_hipaa_mart_portal_user']);
Route::middleware('api')->post('delete_wp_portal_user', [App\Http\Controllers\ApiController::class, '_api_delete_wp_portal_user']);

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']);    
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'users'
], function ($router) {
    Route::get('/list', [UserController::class, 'list']);    
    Route::post('/create', [UserController::class, 'create']);    
    Route::get('/get/{id}', [UserController::class, 'getById']);    
    Route::post('/update/{id}', [UserController::class, 'update']);    
    Route::post('/destroy/{id}', [UserController::class, 'destroy']);    
});