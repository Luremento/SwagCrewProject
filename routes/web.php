<?php

use App\Http\Controllers\{
    ProfileController,
    MainController,
    FollowerController,
    TrackController,
    GenreController,
    ForumTopicController,
    ThreadController,
    CommentController,
    PlaylistController
};
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::controller(MainController::class)->group(function () {
    Route::get('/', 'index')->name('index');
});
Route::get('/forum', [ForumTopicController::class, 'index'])->name('forum.index');
Route::get('/thread/create', [ThreadController::class, 'create'])->name('thread.create');
Route::post('/thread', [ThreadController::class, 'store'])->name('thread.store');
Route::get('/thread/{thread}', [ThreadController::class, 'show'])->name('thread.show');

Route::middleware('auth')->group(function () {
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/avatar-upload', [ProfileController::class, 'uploadAvatar'])->name('profile.avatar.upload');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/password', [ProfileController::class, 'updatePassword'])->name('password.update');
    Route::put('/contacts/{type}', [ProfileController::class, 'updateContact'])->name('contacts.update');
    Route::put('/social-links/{platform}', [ProfileController::class, 'updateSocialLink'])->name('social-links.update');
    Route::get('/profile/{user?}', [ProfileController::class, 'index'])->name('profile.index');


    Route::controller(TrackController::class)->group(function () {
        Route::get('/tracks', 'index')->name('tracks.index');
        Route::get('/tracks/{id}/data', 'getTrackData')->name('tracks.data');
        Route::get('/theme/track/search', 'search')->name('track.search');
        Route::get('/track/create', 'create')->name('track.create');
        Route::post('/tracks', 'store')->name('tracks.store');
        Route::get('/genres/search', 'searchGenres')->name('genres.search');
        Route::get('/tracks/{track}', 'show')->name('tracks.show');
        Route::post('/tracks/{id}/play', [TrackController::class, 'incrementPlayCount'])->name('tracks.play');
    });

    Route::get('/genres/search', [GenreController::class, 'search'])->name('genres.search');

    Route::post('/comment', [CommentController::class, 'store'])->name('comments.store');

    Route::post('/follow/{user}', [FollowerController::class, 'follow'])->name('follow');
    Route::delete('/unfollow/{user}', [FollowerController::class, 'unfollow'])->name('unfollow');

    Route::middleware(['auth'])->group(function () {
        Route::resource('playlists', PlaylistController::class);
        Route::post('/playlists/{playlist}/add-track', [PlaylistController::class, 'addTrack'])->name('playlists.add-track');
        Route::delete('/playlists/{playlist}/remove-track', [PlaylistController::class, 'removeTrack'])->name('playlists.remove-track');
        Route::post('/playlists/{playlist}/reorder-tracks', [PlaylistController::class, 'reorderTracks'])->name('playlists.reorder-tracks');
        Route::get('/playlists-list', [PlaylistController::class, 'getPlaylistsList'])->name('playlists.list');
    });
});

require __DIR__.'/auth.php';