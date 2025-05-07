<?php

use App\Http\Controllers\{
    ProfileController,
    MainController,
    FollowerController,
    TrackController,
    GenreController
};
use Illuminate\Support\Facades\Route;

Route::controller(MainController::class)->group(function () {
    Route::get('/', 'index')->name('index');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/avatar-upload', [ProfileController::class, 'uploadAvatar'])->name('profile.avatar.upload');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/password', [ProfileController::class, 'updatePassword'])->name('password.update');
    Route::put('/contacts/{type}', [ProfileController::class, 'updateContact'])->name('contacts.update');
    Route::put('/social-links/{platform}', [ProfileController::class, 'updateSocialLink'])->name('social-links.update');
    Route::get('/profile/{user?}', [ProfileController::class, 'index'])->name('profile.index');


    Route::controller(TrackController::class)->group(function () {
        Route::get('/track/create', 'create')->name('track.create');
        Route::post('/tracks', 'store')->name('tracks.store');
        Route::get('/tracks/{track}', 'show')->name('tracks.show');
        Route::get('/genres/search', 'searchGenres')->name('genres.search');
    });

    Route::get('/genres/search', [GenreController::class, 'search'])->name('genres.search');

    Route::post('/follow/{user}', [FollowerController::class, 'follow'])->name('follow');
    Route::delete('/unfollow/{user}', [FollowerController::class, 'unfollow'])->name('unfollow');
});

require __DIR__.'/auth.php';
