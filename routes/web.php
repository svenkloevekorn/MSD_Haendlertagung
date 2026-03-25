<?php

use App\Http\Controllers\PinLoginController;
use Illuminate\Support\Facades\Route;

// Login
Route::get('/', [PinLoginController::class, 'show'])->name('login');
Route::post('/login', [PinLoginController::class, 'login'])->name('login.submit');
Route::post('/logout', [PinLoginController::class, 'logout'])->name('logout');

// Geschützte Seiten
Route::middleware('pin')->group(function () {
    Route::get('/startseite', fn () => view('startseite'))->name('startseite');
    Route::get('/agenda', fn () => view('agenda'))->name('agenda');
    Route::get('/galerie', fn () => view('galerie'))->name('galerie');
    Route::get('/downloads', fn () => view('downloads'))->name('downloads');
    Route::get('/formular', fn () => view('formular'))->name('formular');
    Route::get('/feedback', fn () => view('feedback'))->name('feedback');
    Route::get('/kontakt', fn () => view('kontakt'))->name('kontakt');
});
