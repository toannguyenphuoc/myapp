<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

// Route::middleware(['auth'])->group(function () {

//     Route::get('/dashboard', function () {
//         return view('dashboard');
//     })->name('dashboard');

//     // Chỉ admin được vào
//     Route::middleware(['role:admin'])->group(function () {
//         Route::resource('users', UserController::class);
//     });

//     // Editor hoặc Admin có thể manage posts (dựa trên permission)
//     Route::resource('posts', PostController::class)
//         ->middleware('permission:posts.view|posts.create|posts.update|posts.delete');
// });

require __DIR__.'/auth.php';
