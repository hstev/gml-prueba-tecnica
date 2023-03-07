<?php

use App\Http\Controllers\Users;
use App\Http\Controllers\Categories;
use App\Http\Controllers\SearchUser;
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

Route::get('/user', [Users::class, 'index']);
Route::post('/user', [Users::class, 'store']);
Route::delete('/user/{user}', [Users::class, 'destroy']);
Route::get('/category', [Categories::class, 'index']);
Route::post('/user/search', [SearchUser::class, 'index']);

