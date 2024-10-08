<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;


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
Route::post("connexion", [UserController::class, "connexion"]);
Route::post("users", [UserController::class, "create"]);
Route::put("users/{id}", [UserController::class, "update"]);
Route::get("users/{id}", [UserController::class, "get_one_user"]);
Route::get("users", [UserController::class, "index"]);
Route::delete("users/{id}", [UserController::class, "destroy"]);


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
