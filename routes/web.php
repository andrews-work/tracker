<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Middleware\CheckAuthLevel;
use App\Http\Controllers\TodoListController;

// home 
Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

// dashboard
Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// todo
Route::get('/todo', function () {
    return Inertia::render('Todo', [
        'layout' => 'Layouts.TodoLayout',
    ]);
})->middleware(['auth', 'verified'])->name('todo');

// calendar
Route::get('/calendar', function () {
    return Inertia::render('Calendar');
})->middleware(['auth', 'verified', 'auth:4'])->name('calendar');


// todo list
Route::middleware('auth', 'verified')->group(function () {
    // show
    Route::get('/todoList', [TodoListController::class, 'show'])->name('todoList.show');
    // create
    Route::post('/todoList', [TodoListController::class, 'store'])->name('todoList.store');
    // delete
    Route::delete('/todoList/{todoList}', [TodoListController::class, 'destroy'])->name('todoList.destroy');
});

// profile
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
