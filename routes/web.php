<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClubController;
use App\Http\Controllers\UserController;

// Главная страница
Route::get('/', function () {
    return redirect()->route('clubs.index');
});

// Маршруты аутентификации
require __DIR__.'/auth.php';

// ==================== КЛУБЫ ====================

// Удалённые клубы, только для админа
Route::middleware('auth')->group(function () {
    Route::get('clubs/trashed', [ClubController::class, 'trashed'])->name('clubs.trashed');
    Route::post('clubs/{club}/restore', [ClubController::class, 'restore'])->name('clubs.restore');
    Route::delete('clubs/{club}/force-delete', [ClubController::class, 'forceDelete'])->name('clubs.force-delete');
});

// Стандартные CRUD маршруты
Route::resource('clubs', ClubController::class);

// пользователи

Route::get('users', [UserController::class, 'index'])->name('users.index');
Route::get('users/{user}', [UserController::class, 'show'])->name('users.show');