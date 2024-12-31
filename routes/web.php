<?php

use App\Http\Middleware\EnsurePasswordIsUpdated;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\PaymentController;
// use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Route::get('/', function () {
//     return Inertia::render('Welcome', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// });

Route::redirect('/', '/login');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    
    Route::middleware([EnsurePasswordIsUpdated::class])->group(function () {
        Route::get('/dashboard', function () {
            return Inertia::render('Dashboard');
        })->name('dashboard');
    });

    Route::get('/{category}', [CourseController::class, 'index'])->name('courses.index');
    Route::get('/transactions', [PaymentController::class, 'transactions'])->name('transactions');
});
