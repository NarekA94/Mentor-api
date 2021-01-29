<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GroupController;
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
Route::prefix('v1')->group(function () {

    Route::prefix('auth')->group(function () {
        Route::post('signin',[AuthController::class, 'signIn']);
        Route::post('signup',[AuthController::class, 'signUp']);
    });
    
    Route::get('/users',[UserController::class,'getUsers']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::prefix('auth')->group(function () {
            Route::post('signout',[AuthController::class, 'signOut']);
            Route::get('refresh',[AuthController::class, 'refreshToken']);
        });

        Route::prefix('user')->group(function(){
            Route::get('/',[UserController::class,'getUser']);
        });
        Route::prefix('group')->group(function(){
            Route::get('/get-user-group',[GroupController::class,'getUserGroup']);
            Route::post('/edit/{id}',[GroupController::class,'edit']);
            Route::post('/create',[GroupController::class,'create']);
        });
    });

});
