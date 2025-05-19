<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use App\Models\Track;
use App\Models\Playlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Track\UploadTrackRequest;

class TrackController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Получаем все жанры
        $genres = Genre::withCount('tracks')->get();

        // Получаем плейлисты пользователя
        $playlists = Auth::check() ? Auth::user()->playlists()->withCount('tracks')->get() : collect([]);

        // Определяем тип отображения (список или сетка)
        $viewType = $request->query('view_type', 'list');

        // Базовый запрос для треков
        $tracksQuery = Track::with(['user', 'genre']);

        $currentGenre = null;
        // Фильтрация по жанру, если указан
        if ($request->has('genre_id')) {
            $tracksQuery->where('genre_id', $request->genre_id);
            $currentGenre = Genre::findOrFail($request->genre_id);
        }

        // Сортировка
        if ($request->query('sort') === 'popular') {
            $tracksQuery->orderBy('play_count', 'desc');
        } else {
            $tracksQuery->latest();
        }

        // Получаем треки с пагинацией
        $tracks = $tracksQuery->paginate(15);

        return view('tracks', compact('tracks', 'genres', 'playlists', 'viewType', 'currentGenre'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $genres = Genre::all();
        return view('track.upload', compact('genres'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UploadTrackRequest $request)
    {
        $track = new Track();
        $track->user_id = Auth::id();
        $track->title = $request->title;
        $track->description = $request->description;
        $track->genre_id = $request->genre_id;

        // Обработка загрузки аудиофайла
        if ($request->hasFile('audio_file')) {
            $audioPath = $request->file('audio_file')->store('tracks', 'public');
            $track->audio_path = $audioPath;
        }

        // Обработка загрузки обложки
        if ($request->hasFile('cover_image')) {
            $coverPath = $request->file('cover_image')->store('covers', 'public');
            $track->cover_image = $coverPath;
        }

        $track->save();

        // Добавляем трек в плейлист "Избранное", если он существует
        if ($request->has('add_to_favorites') && $request->add_to_favorites) {
            $favoritePlaylist = Auth::user()->playlists()->where('name', 'Избранное')->first();

            if (!$favoritePlaylist) {
                // Создаем плейлист "Избранное", если он не существует
                $favoritePlaylist = new Playlist();
                $favoritePlaylist->user_id = Auth::id();
                $favoritePlaylist->name = 'Избранное';
                $favoritePlaylist->is_public = false;
                $favoritePlaylist->save();
            }

            // Добавляем трек в плейлист
            $favoritePlaylist->tracks()->attach($track->id, ['position' => $favoritePlaylist->tracks()->count() + 1]);
        }

        return redirect()->route('tracks.show', $track->id)->with('success', 'Трек успешно загружен!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Track $track)
    {
        $track->load(['user', 'genre', 'comments.user']);

        // Получаем плейлисты пользователя
        $playlists = Auth::check() ? Auth::user()->playlists()->withCount('tracks')->get() : collect([]);

        // Получаем похожие треки (того же жанра)
        $similarTracks = Track::where('genre_id', $track->genre_id)
            ->where('id', '!=', $track->id)
            ->with('user')
            ->inRandomOrder()
            ->limit(5)
            ->get();

        return view('track.show', compact('track', 'playlists', 'similarTracks'));
    }

    /**
     * Get track data for the audio player.
     */
    public function getTrackData($id)
    {
        $track = Track::with(['user', 'genre'])->findOrFail($id);

        return response()->json([
            'id' => $track->id,
            'title' => $track->title,
            'artist' => $track->user->name,
            'audio_url' => asset('storage/' . $track->audio_path),
            'cover_image' => $track->cover_image ? asset('storage/' . $track->cover_image) : null,
            'genre' => $track->genre->name,
            'created_at' => $track->created_at->diffForHumans(),
            'user_id' => $track->user->id,
            'user_profile_url' => route('profile.index', $track->user->id)
        ]);
    }

    /**
     * Increment play count for a track.
     */
    public function incrementPlayCount($id)
    {
        $track = Track::findOrFail($id);
        $track->increment('play_count');

        return response()->json(['success' => true, 'play_count' => $track->play_count]);
    }

    /**
     * Search for tracks.
     */
    public function search(Request $request)
    {
        $query = $request->input('query');

        if (empty($query)) {
            return response()->json([]);
        }

        $tracks = Track::where('title', 'like', "%{$query}%")
            ->with(['user', 'genre'])
            ->limit(10)
            ->get()
            ->map(function ($track) {
                return [
                    'id' => $track->id,
                    'title' => $track->title,
                    'artist' => $track->user->name,
                    'cover_image' => $track->cover_image ? asset('storage/' . $track->cover_image) : null,
                    'genre' => $track->genre->name,
                    'url' => route('tracks.show', $track->id)
                ];
            });

        return response()->json($tracks);
    }

    /**
     * Search for genres.
     */
    public function searchGenres(Request $request)
    {
        $query = $request->input('query');

        if (empty($query)) {
            return response()->json([]);
        }

        $genres = Genre::where('name', 'like', "%{$query}%")
            ->limit(10)
            ->get()
            ->map(function ($genre) {
                return [
                    'id' => $genre->id,
                    'name' => $genre->name
                ];
            });

        return response()->json($genres);
    }
}
