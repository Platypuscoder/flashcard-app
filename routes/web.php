<?php
// flashcard-app/routes/web.php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DeckController;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

// Public routes
Route::get('/admin/decks/list', function () {
    return view('Admin.Decks.List');
})->name('admin-decks-list');

Route::get('/admin/about/faq', function () {
    return view('Admin.About.Faq');
})->name('admin-about-faq');

Route::get('/admin/about/about', function () {
    return view('Admin.About.About');
})->name('admin-about-about');

// Authenticated routes
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/admin/decks/create', function () {
        return view('Admin.Decks.Create');
    })->name('admin-decks-create');

    Route::get('/admin/decks/view/{id}', [DeckController::class, 'view'])->name('admin-decks-view');

    Route::get('/admin/decks/Flashcard', function () {
        return view('Admin.Decks.Flashcard');
    })->name('admin-decks-flashcard');
});
