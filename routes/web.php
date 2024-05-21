<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('home');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['hasRole:admin,hr', 'auth'])->prefix('users')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('user.index');
    Route::get('/show/{userId}', [UserController::class, 'show'])->name('user.show');
    Route::get('/edit/{userId}', [UserController::class, 'edit'])->name('user.edit');
    Route::patch('/edit', [UserController::class, 'update'])->name('user.update');
    Route::delete('/edit', [UserController::class, 'destroy'])->name('user.destroy');
});

Route::middleware('auth')->prefix('profile')->group(function () {
    Route::get('/', [ProfileController::class, 'show'])->name('show');
    Route::get('/', [ProfileController::class, 'edit'])->name('edit');
    Route::patch('/update', [ProfileController::class, 'update'])->name('update');
});

Route::middleware('auth')->prefix('book')->group(function () {
    Route::get('/', [BookController::class, 'index'])->name('book.index');
    Route::get('/create', [BookController::class, 'create'])->name('book.create');
    Route::post('/store', [BookController::class, 'store'])->name('book.store');
    Route::get('/{book}/edit', [BookController::class, 'edit'])->name('book.edit');
    Route::patch('/{book}', [BookController::class, 'update'])->name('book.update');
    Route::delete('/{book}', [BookController::class, 'destroy'])->name('book.destroy');
});

Route::middleware('auth')->prefix('profile')->group(function(){
    Route::get('/{userId}', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/edit/{userId}', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/update/{userId}', [ProfileController::class, 'update'])->name('profile.update');
});


require __DIR__.'/auth.php';
