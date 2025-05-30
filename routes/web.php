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
use App\Http\Controllers\AdminController;
use App\Http\Controllers\FavoriteController;
use App\Http\Middleware\{IsAdmin, CheckUserBlocked};
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::middleware(CheckUserBlocked::class)->group(function () {
    Route::controller(MainController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/search', 'search')->name('search.index');
        Route::get('/search/suggestions', 'searchSuggestions')->name('search.suggestions');

    });
    Route::post('/favorites/toggle/{track}', [FavoriteController::class, 'toggle'])->name('favorites.toggle');
    Route::get('/forum', [ForumTopicController::class, 'index'])->name('forum.index');
    Route::middleware('auth')->group(function () {
        Route::get('/thread/create', [ThreadController::class, 'create'])->name('thread.create');
        Route::post('/thread', [ThreadController::class, 'store'])->name('thread.store');
        Route::get('/thread/{thread}/edit', [ThreadController::class, 'edit'])->name('thread.edit');
        Route::put('/thread/{id}', [App\Http\Controllers\ThreadController::class, 'update'])->name('thread.update');
        Route::delete('/thread/{id}', [App\Http\Controllers\ThreadController::class, 'destroy'])->name('thread.destroy');
    });
    Route::get('/thread/{thread}', [ThreadController::class, 'show'])->name('thread.show');


    Route::get('/tracks', [TrackController::class, 'index'])->name('tracks.index');
    // Route::get('/tracks/{track}', [TrackController::class, 'show'])->name('tracks.show');
    Route::middleware('auth')->group(function () {
        Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::post('/profile/avatar-upload', [ProfileController::class, 'uploadAvatar'])->name('profile.avatar.upload');
        Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::put('/password', [ProfileController::class, 'updatePassword'])->name('password.update');
        Route::put('/contacts/{type}', [ProfileController::class, 'updateContact'])->name('contacts.update');
        Route::put('/social-links/{platform}', [ProfileController::class, 'updateSocialLink'])->name('social-links.update');
        Route::get('/profile/{user?}', [ProfileController::class, 'index'])->name('profile.index');

        // Мягкое удаление трека
        Route::delete('/tracks/{track}/soft-delete', [TrackController::class, 'softDelete'])->name('tracks.soft-delete');

        // Восстановление трека (только для админов)
        Route::patch('/tracks/{id}/restore', [TrackController::class, 'restore'])->name('tracks.restore');

        // Окончательное удаление трека (только для админов)
        Route::delete('/tracks/{id}/force-delete', [TrackController::class, 'forceDelete'])->name('tracks.force-delete');
        Route::controller(TrackController::class)->group(function () {
            Route::get('/tracks/{id}/data', [TrackController::class, 'getTrackData'])->name('tracks.data');
            Route::get('/theme/track/search', 'search')->name('track.search');
            Route::get('/track/create', 'create')->name('track.create');
            Route::post('/tracks', 'store')->name('tracks.store');
            Route::get('/genres/search', 'searchGenres')->name('genres.search');
            Route::get('/tracks/{track}', 'show')->name('tracks.show');
            Route::post('/tracks/{id}/play', [TrackController::class, 'incrementPlayCount'])->name('tracks.play');
            Route::get('/tracks/{track}/stream', [TrackController::class, 'stream'])->name('tracks.stream');
        });


        Route::get('/genres/search', [GenreController::class, 'search'])->name('genres.search');

        Route::post('/comment', [CommentController::class, 'store'])->name('comments.store');
        // Новые маршруты для редактирования и удаления
        Route::put('/comments/{comment}', [CommentController::class, 'update'])->name('comments.update');
        Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

        Route::post('/follow/{user}', [FollowerController::class, 'follow'])->name('follow');
        Route::delete('/unfollow/{user}', [FollowerController::class, 'unfollow'])->name('unfollow');

        Route::middleware(['auth'])->group(function () {
            Route::resource('playlists', PlaylistController::class);
            Route::post('/playlists/{playlist}/add-track', [PlaylistController::class, 'addTrack'])->name('playlists.add-track');
            Route::delete('/playlists/{playlist}/remove-track', [PlaylistController::class, 'removeTrack'])->name('playlists.remove-track');
            Route::post('/playlists/{playlist}/reorder-tracks', [PlaylistController::class, 'reorderTracks'])->name('playlists.reorder-tracks');
            Route::get('/playlists-list', [PlaylistController::class, 'getPlaylistsList'])->name('playlists.list');
        });

        Route::middleware(['auth', IsAdmin::class])->prefix('admin')->name('admin.')->group(function () {
            Route::get('/', [AdminController::class, 'index'])->name('dashboard');
            Route::get('/users', [AdminController::class, 'users'])->name('users');

            // Управление пользователями
            Route::post('/users/{user}/toggle-role', [AdminController::class, 'toggleUserRole'])->name('users.toggle-role');
            Route::post('/users/{user}/toggle-block', [AdminController::class, 'toggleUserBlock'])->name('users.toggle-block');

            // Экспорт
            Route::get('/export/users/excel', [AdminController::class, 'exportUsersExcel'])->name('export.users.excel');
            Route::get('/export/users/pdf', [AdminController::class, 'exportUsersPdf'])->name('export.users.pdf');
            Route::get('/export/tracks/excel', [AdminController::class, 'exportTracksExcel'])->name('export.tracks.excel');
        });
    });
});

require __DIR__ . '/auth.php';
