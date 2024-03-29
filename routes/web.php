<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GuestLoginController;

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

Route::get('/guest', [GuestLoginController::class, 'guestLogin'])->name('guest.login');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/send', [App\Http\Controllers\ChatController::class, 'send'])->name('send');
    Route::get('/message', [App\Http\Controllers\ChatController::class, 'fetchMessages'])->name('fetchMessages');
    Route::get('/user', [App\Http\Controllers\ChatController::class, 'user'])->name('fetchMessages');
    Route::get('/chat/{any}', function ($any) {
        return view('dashboard');
    })->where('any', '.*');
});



require __DIR__ . '/auth.php';
