<?php

namespace App\Http\Controllers;

use App\Models\Track;
use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{

    /**
     * Отображение списка избранных треков пользователя.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $favorites = Auth::user()->favoriteTracks()->with(['user', 'genre'])->paginate(10);

        return view('favorites.index', compact('favorites'));
    }

    /**
     * Добавление трека в избранное.
     *
     * @param  int  $trackId
     * @return \Illuminate\Http\Response
     */
    public function add($trackId)
    {
        $track = Track::findOrFail($trackId);

        // Проверяем, не добавлен ли уже трек в избранное
        if (!Auth::user()->hasFavorite($trackId)) {
            // Создаем запись в таблице избранных
            Favorite::create([
                'user_id' => Auth::id(),
                'track_id' => $trackId
            ]);

            $message = 'Трек добавлен в избранное';
            $status = true;
        } else {
            $message = 'Трек уже в избранном';
            $status = true;
        }

        if (request()->ajax()) {
            return response()->json([
                'status' => $status,
                'message' => $message,
                'count' => $track->favoritesCount()
            ]);
        }

        return back()->with('success', $message);
    }

    /**
     * Удаление трека из избранного.
     *
     * @param  int  $trackId
     * @return \Illuminate\Http\Response
     */
    public function remove($trackId)
    {
        $track = Track::findOrFail($trackId);

        // Удаляем запись из таблицы избранных
        Favorite::where('user_id', Auth::id())
            ->where('track_id', $trackId)
            ->delete();

        $message = 'Трек удален из избранного';
        $status = false;

        if (request()->ajax()) {
            return response()->json([
                'status' => $status,
                'message' => $message,
                'count' => $track->favoritesCount()
            ]);
        }

        return back()->with('success', $message);
    }

    /**
     * Переключение статуса избранного (добавление/удаление).
     *
     * @param  int  $trackId
     * @return \Illuminate\Http\Response
     */
    public function toggle($trackId)
    {
        $track = Track::findOrFail($trackId);

        // Проверяем, есть ли трек в избранном
        $favorite = Favorite::where('user_id', Auth::id())
            ->where('track_id', $trackId)
            ->first();

        if ($favorite) {
            // Если трек уже в избранном, удаляем его
            $favorite->delete();
            $message = 'Трек удален из избранного';
            $status = false;
        } else {
            // Если трека нет в избранном, добавляем его
            Favorite::create([
                'user_id' => Auth::id(),
                'track_id' => $trackId
            ]);
            $message = 'Трек добавлен в избранное';
            $status = true;
        }

        if (request()->ajax()) {
            return response()->json([
                'status' => $status,
                'message' => $message,
                'count' => $track->favoritesCount()
            ]);
        }

        return back()->with('success', $message);
    }

    /**
     * Получение списка избранных треков для API.
     *
     * @return \Illuminate\Http\Response
     */
    public function apiGetFavorites()
    {
        $favorites = Auth::user()->favoriteTracks()
            ->with(['user', 'genre'])
            ->get();

        return response()->json([
            'favorites' => $favorites
        ]);
    }

    /**
     * Проверка, находится ли трек в избранном.
     *
     * @param  int  $trackId
     * @return \Illuminate\Http\Response
     */
    public function checkFavorite($trackId)
    {
        $isFavorite = Auth::user()->hasFavorite($trackId);

        return response()->json([
            'is_favorite' => $isFavorite
        ]);
    }
}
