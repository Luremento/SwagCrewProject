<?php

namespace App\Http\Controllers;

use App\Models\Playlist;
use App\Models\Track;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PlaylistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $playlists = Auth::user()->playlists()->withCount('tracks')->get();
        return view('playlists.index', compact('playlists'));
    }

    /**
     * Get a list of user's playlists for the selector.
     */
    public function getPlaylistsList()
    {
        $playlists = Auth::user()->playlists()->select('id', 'name')->get();

        if (request()->ajax() || request()->wantsJson()) {
            return response()->json($playlists);
        }

        return $playlists;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('playlists.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'description' => 'nullable|string',
            'cover_image' => 'nullable|image|max:2048',
            'is_public' => 'nullable|boolean',
            'redirect_with_track_id' => 'nullable|exists:tracks,id',
        ]);

        if ($validator->fails()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $playlist = new Playlist();
        $playlist->user_id = Auth::id();
        $playlist->name = $request->name;
        $playlist->description = $request->description;

        // ИСПРАВЛЕНИЕ: Правильная обработка чекбокса
        $playlist->is_public = $request->boolean('is_public');

        // Обработка загрузки обложки
        if ($request->hasFile('cover_image')) {
            $coverPath = $request->file('cover_image')->store('playlist_covers', 'public');
            $playlist->cover_image = $coverPath;
        }

        $playlist->save();

        // Если был передан ID трека, добавляем его в новый плейлист
        if ($request->has('redirect_with_track_id')) {
            $trackId = $request->redirect_with_track_id;
            $playlist->tracks()->attach($trackId, ['position' => 1]);

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Плейлист успешно создан и трек добавлен!',
                    'playlist' => $playlist
                ], 201);
            }

            return redirect()->back()->with('success', 'Плейлист успешно создан и трек добавлен!');
        }

        // Проверяем, был ли запрос AJAX или ожидается JSON
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Плейлист успешно создан!',
                'playlist' => $playlist,
                'redirect_url' => route('playlists.show', $playlist)
            ], 201);
        }

        // Если это обычная отправка формы, перенаправляем на страницу плейлиста
        return redirect()->route('playlists.show', $playlist)->with('success', 'Плейлист успешно создан!');
    }


    /**
     * Display the specified resource.
     */
    public function show(Playlist $playlist)
    {
        // Проверяем доступ к плейлисту
        if (!$playlist->is_public && $playlist->user_id !== Auth::id()) {
            abort(403, 'У вас нет доступа к этому плейлисту');
        }

        $playlist->load([
            'tracks' => function ($query) {
                $query->orderBy('playlist_track.position', 'asc');
            },
            'tracks.user',
            'tracks.genre'
        ]);

        return view('playlist.show', compact('playlist'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Playlist $playlist)
    {
        // Проверяем, что пользователь является владельцем плейлиста
        if ($playlist->user_id !== Auth::id()) {
            abort(403, 'У вас нет прав на редактирование этого плейлиста');
        }

        return view('playlists.edit', compact('playlist'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Playlist $playlist)
    {
        // Проверяем права доступа
        if ($playlist->user_id !== Auth::id()) {
            abort(403, 'У вас нет прав для редактирования этого плейлиста');
        }

        $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'nullable|string|max:500',
            'cover_image' => 'nullable|image|max:2048',
            'is_public' => 'nullable|boolean',
        ]);

        // Обновляем основные поля
        $playlist->name = $request->name;
        $playlist->description = $request->description;
        $playlist->is_public = $request->boolean('is_public');

        // Обработка загрузки новой обложки
        if ($request->hasFile('cover_image')) {
            // Удаляем старую обложку, если она существует
            if ($playlist->cover_image) {
                Storage::disk('public')->delete($playlist->cover_image);
            }

            // Загружаем новую обложку
            $coverPath = $request->file('cover_image')->store('playlist_covers', 'public');
            $playlist->cover_image = $coverPath;
        }

        $playlist->save();

        return redirect()->route('playlists.show', $playlist)
            ->with('success', 'Плейлист успешно обновлен!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Playlist $playlist)
    {
        // Проверяем, что пользователь является владельцем плейлиста
        if ($playlist->user_id !== Auth::id()) {
            return redirect()->route('index')->with('success', 'Плейлист успешно удален!');
        }

        // Удаляем обложку, если она есть
        if ($playlist->cover_image) {
            Storage::disk('public')->delete($playlist->cover_image);
        }

        $playlist->delete();

        return redirect()->route('index')->with('success', 'Плейлист успешно удален!');
    }

    /**
     * Add a track to the playlist.
     */
    public function addTrack(Request $request, Playlist $playlist)
    {
        // Проверяем, что пользователь является владельцем плейлиста
        if ($playlist->user_id !== Auth::id()) {
            if ($request->wantsJson()) {
                return response()->json(['error' => 'У вас нет прав на редактирование этого плейлиста'], 403);
            }
            return redirect()->back()->with('error', 'У вас нет прав на редактирование этого плейлиста');
        }

        $validator = Validator::make($request->all(), [
            'track_id' => 'required|exists:tracks,id',
        ]);

        if ($validator->fails()) {
            if ($request->wantsJson()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            return redirect()->back()->withErrors($validator);
        }

        $trackId = $request->track_id;

        // Проверяем, есть ли уже этот трек в плейлисте
        if ($playlist->tracks()->where('track_id', $trackId)->exists()) {
            if ($request->wantsJson()) {
                return response()->json(['message' => 'Этот трек уже добавлен в плейлист'], 200);
            }
            return redirect()->back()->with('info', 'Этот трек уже добавлен в плейлист');
        }

        // Получаем максимальную позицию в плейлисте
        $maxPosition = $playlist->tracks()->max('playlist_track.position') ?? 0;

        // Добавляем трек в плейлист
        $playlist->tracks()->attach($trackId, ['position' => $maxPosition + 1]);

        if ($request->wantsJson()) {
            return response()->json(['message' => 'Трек успешно добавлен в плейлист'], 200);
        }

        return redirect()->back()->with('success', 'Трек успешно добавлен в плейлист');
    }

    /**
     * Remove a track from the playlist.
     */
    public function removeTrack(Request $request, Playlist $playlist)
    {
        // Проверяем права доступа
        if ($playlist->user_id !== Auth::id()) {
            abort(403, 'У вас нет прав для изменения этого плейлиста');
        }

        $request->validate([
            'track_id' => 'required|exists:tracks,id'
        ]);

        $trackId = $request->track_id;

        // Удаляем трек из плейлиста
        $playlist->tracks()->detach($trackId);

        return redirect()->route('playlists.show', $playlist)
            ->with('success', 'Трек успешно удален из плейлиста!');
    }

    /**
     * Reorder tracks in the playlist.
     */
    public function reorderTracks(Request $request, Playlist $playlist)
    {
        // Проверяем, что пользователь является владельцем плейлиста
        if ($playlist->user_id !== Auth::id()) {
            return response()->json(['error' => 'У вас нет прав на редактирование этого плейлиста'], 403);
        }

        $validator = Validator::make($request->all(), [
            'tracks' => 'required|array',
            'tracks.*' => 'exists:tracks,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $trackIds = $request->tracks;

        // Обновляем позиции треков
        foreach ($trackIds as $index => $trackId) {
            $playlist->tracks()->updateExistingPivot($trackId, ['position' => $index + 1]);
        }

        return response()->json(['message' => 'Порядок треков успешно обновлен']);
    }
}