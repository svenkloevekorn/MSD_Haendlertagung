<?php

use App\Http\Controllers\AgendaController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\SpeakerController;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\PinLoginController;
use Illuminate\Support\Facades\Route;

// Login
Route::get('/', [PinLoginController::class, 'show'])->name('login');
Route::post('/login', [PinLoginController::class, 'login'])->name('login.submit');
Route::post('/logout', [PinLoginController::class, 'logout'])->name('logout');

// Geschützte Seiten
Route::middleware('pin')->group(function () {
    Route::get('/startseite', fn () => view('startseite'))->name('startseite');
    Route::get('/agenda', [AgendaController::class, 'index'])->name('agenda');
    Route::get('/galerie', [GalleryController::class, 'index'])->name('galerie');
    Route::get('/galerie/{galleryImage}/image', [GalleryController::class, 'show'])->name('galerie.image');
    Route::get('/downloads', [DownloadController::class, 'index'])->name('downloads');
    Route::get('/downloads/{download}/file', [DownloadController::class, 'file'])->name('downloads.file');
    Route::get('/speakers/{speaker}/image', [SpeakerController::class, 'image'])->name('speakers.image');
    Route::get('/formular', [RegistrationController::class, 'show'])->name('formular');
    Route::post('/formular', [RegistrationController::class, 'submit'])->name('formular.submit');
    Route::get('/feedback', fn () => view('feedback'))->name('feedback');
    Route::get('/kontakt', [ContactController::class, 'index'])->name('kontakt');
    Route::get('/kontakt/{contactPerson}/image', [ContactController::class, 'image'])->name('kontakt.image');
});
