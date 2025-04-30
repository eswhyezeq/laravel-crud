<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\TodoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
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

Auth::routes();

Route::get('/todo', [TodoController::class, 'index'])->name('todo.index');
Route::post('/todo', [TodoController::class, 'store'])->name('todo.store');
Route::get('/todo/{todo}/edit', [TodoController::class, 'edit'])->name('todo.edit');
Route::delete('/todo/{todo}', [TodoController::class, 'destroy'])->name('todo.destroy');
Route::put('/todo/{todo}', [TodoController::class, 'update'])->name('todo.update');
Route::get('/todo/create', [TodoController::class, 'create'])->name('todo.create');

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/delete', [ProfileController::class, 'destroy'])->name('profile.delete');
});