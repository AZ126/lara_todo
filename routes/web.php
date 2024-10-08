<?php

use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/', [TaskController::class, 'index']);
    Route::resource('tasks', TaskController::class);
    Route::view('my/notifications', 'user-notifications')->name('user.notify');
    Route::get('/mark-as-read', [TaskController::class, 'markAsRead'])->name('mark-as-read');
});
