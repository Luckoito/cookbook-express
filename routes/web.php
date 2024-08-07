<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MeasureController;
use App\Http\Controllers\IngredientController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\TastingController;
use App\Http\Controllers\DashboardController;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

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
    return redirect()->route('dashboard');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['hasRole:admin,hr', 'auth'])->prefix('users')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('user.index');
    Route::get('/show/{userId}', [UserController::class, 'show'])->name('user.show');
    Route::get('/edit/{userId}', [UserController::class, 'edit'])->name('user.edit');
    Route::patch('/edit', [UserController::class, 'update'])->name('user.update');
    Route::delete('/edit', [UserController::class, 'destroy'])->name('user.destroy');
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
    Route::get('/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/{userId}', [ProfileController::class, 'show'])->name('profile.show');
    Route::post('/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/store', [ProfileController::class,'store'])->name('profile.store');
});

Route::middleware(['auth', 'hasRole:admin'])->prefix('role')->group(function () {
    Route::get('/', [RoleController::class,'index'])->name('role.index');
    Route::post('/store', [RoleController::class, 'store'])->name('role.store');
    Route::post('/delete', [RoleController::class,'delete'])->name('role.delete');

    Route::post('activate', [RoleController::class,'activate'])->name('role.activate');
    Route::post('deactivate', [RoleController::class,'deactivate'])->name('role.deactivate');
});

Route::middleware(['auth', 'hasRole:admin,hr'])->prefix('restaurant')->group(function () {
    Route::get('/', [RestaurantController::class,'index'])->name('restaurant.index');
    Route::post('/store', [RestaurantController::class, 'store'])->name('restaurant.store');
    Route::post('/delete', [RestaurantController::class,'delete'])->name('restaurant.delete');
});

Route::middleware('auth')->prefix('employee')->group(function () {
    Route::post('/addExperience', [EmployeeController::class, 'addExperience'])->name('employee.addExperience');
    Route::post('/removeExperience', [EmployeeController::class, 'removeExperience'])->name('employee.removeExperience');
});

Route::middleware(['auth', 'hasRole:admin,chef'])->prefix('category')->group(function () {
    Route::get('/', [CategoryController::class, 'index'])->name('category.index');
    Route::post('/store', [CategoryController::class, 'store'])->name('category.store');
    Route::post('/update', [CategoryController::class, 'update'])->name('category.update');
    Route::post('/delete', [CategoryController::class, 'delete'])->name('category.delete');
});

Route::middleware(['auth', 'hasRole:admin,chef'])->prefix('measure')->group(function () {
    Route::get('/', [MeasureController::class, 'index'])->name('measure.index');
    Route::post('/store', [MeasureController::class, 'store'])->name('measure.store');
    Route::post('/update', [MeasureController::class, 'update'])->name('measure.update');
    Route::post('/delete', [MeasureController::class, 'delete'])->name('measure.delete');
});

Route::middleware(['auth', 'hasRole:admin,chef'])->prefix('ingredient')->group(function () {
    Route::get('/', [IngredientController::class, 'index'])->name('ingredient.index');
    Route::post('/store', [IngredientController::class, 'store'])->name('ingredient.store');
    Route::post('/update', [IngredientController::class, 'update'])->name('ingredient.update');
    Route::post('/delete', [IngredientController::class, 'delete'])->name('ingredient.delete');
});

Route::middleware(['auth', 'hasRole:admin,chef'])->prefix('ingredient')->group(function () {
    Route::get('/', [IngredientController::class, 'index'])->name('ingredient.index');
    Route::post('/store', [IngredientController::class, 'store'])->name('ingredient.store');
    Route::post('/update', [IngredientController::class, 'update'])->name('ingredient.update');
    Route::post('/delete', [IngredientController::class, 'delete'])->name('ingredient.delete');
});

Route::middleware(['auth'])->prefix('recipe')->group(function () {
    Route::get('/', [RecipeController::class, 'index'])->name('recipe.index');
    Route::get('/show/{id}', [RecipeController::class,'show'])->name('recipe.show');

    Route::middleware(['hasRole:admin,chef'])->group(function () {
        Route::get('/create', [RecipeController::class, 'create'])->name('recipe.create');
        Route::post('/store', [RecipeController::class, 'store'])->name('recipe.store');
        Route::get('/edit/{id}', [RecipeController::class, 'edit'])->name('recipe.edit');
        Route::patch('/update', [RecipeController::class, 'update'])->name('recipe.update');
        Route::get('/{id}', [RecipeController::class, 'destroy'])->name('recipe.delete');
    });
});

Route::middleware(['auth'])->prefix('book')->group(function () {
    Route::get('/', [BookController::class, 'index'])->name('book.index');
    Route::get('/show/{id}', [BookController::class,'show'])->name('book.show');

    Route::middleware(['hasRole:admin,publisher'])->group(function () {
        Route::get('/create', [BookController::class, 'create'])->name('book.create');
        Route::post('/store', [BookController::class, 'store'])->name('book.store');
        Route::get('/publish/{id}', [BookController::class, 'publish'])->name('book.publish');
        Route::get('/{book}/edit', [BookController::class, 'edit'])->name('book.edit');
        Route::patch('/update', [BookController::class, 'update'])->name('book.update');
        Route::get('/{id}', [BookController::class, 'destroy'])->name('book.delete');
    });
});

Route::middleware(['auth'])->prefix('tasting')->group(function () {
    Route::get('/', [TastingController::class, 'index'])->name('tasting.index');

    Route::middleware(['hasRole:admin,taster'])->group(function () {
        Route::get('/create', [TastingController::class, 'create'])->name('tasting.create');
        Route::post('/store', [TastingController::class, 'store'])->name('tasting.store');
        Route::get('/edit/{id}', [TastingController::class, 'edit'])->name('tasting.edit');
        Route::patch('/update', [TastingController::class, 'update'])->name('tasting.update');
        Route::get('/delete/{id}', [TastingController::class, 'destroy'])->name('tasting.delete');
    });
});

require __DIR__.'/auth.php';
