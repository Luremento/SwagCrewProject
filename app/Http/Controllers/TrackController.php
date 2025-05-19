<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Track\UploadTrackRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\{Track, File, Genre, Playlist};
use Illuminate\Support\Facades\{Auth, Storage};

class TrackController extends Controller
{
    public function index(Request $request)
    {
        $genres = Genre::all();

        $currentGenre = null;
        // Get the query parameters
        $genreId = $request->input('genre_id');
        $sort = $request->input('sort', 'latest');
        $viewType = $request->input('view_type', 'grid'); // Default to grid view

        // Start with a base query
        $tracksQuery = Track::query();

        // Apply genre filter if specified
        if ($genreId) {
            $tracksQuery->where('genre_id', $genreId);
            $currentGenre = Genre::find($genreId);
        }

        // Apply sorting
        if ($sort === 'popular') {
            $tracksQuery->orderBy('play_count', 'desc');
        } else {
            $tracksQuery->latest();
        }

        // Get the tracks
        $tracks = $tracksQuery->get();

        $playlists = Playlist::with('tracks')->where('user_id', Auth::id())->get();
        return view('tracks', compact('genres', 'tracks', 'viewType', 'currentGenre', 'playlists'));
    }

    // Add this method to your TrackController to get track data for playback
    public function getTrackData($id)
    {
        $track = Track::with(['user', 'files', 'genre'])->findOrFail($id);

        return response()->json([
            'id' => $track->id,
            'title' => $track->title,
            'artist' => $track->user->name,
            'cover' => $track->cover_image ? asset('storage/' . $track->cover_image) : null,
            'audio_url' => $track->files->first() ? asset('storage/' . $track->files->first()->path) : null,
            'genre' => $track->genre->name,
            'created_at' => $track->created_at->diffForHumans(),
        ]);
    }

    public function create() {
        return view('track.upload');
    }

    /**
     * Сохранить новый трек
     */
    public function store(UploadTrackRequest $request)
    {
        // Валидация данных
        $validated = $request->validated();

        // Обработка жанра
        $genre = Genre::firstOrCreate(['name' => $validated['genre']]);

        // Обработка аудио файла
        $audioFile = $request->file('audio_file');
        $audioFileName = Str::uuid() . '.' . $audioFile->getClientOriginalExtension();
        $audioPath = $audioFile->storeAs('tracks', $audioFileName, 'public');

        // Обработка обложки
        $coverImage = $request->file('cover_image');
        $coverFileName = Str::uuid() . '.' . $coverImage->getClientOriginalExtension();
        $coverPath = $coverImage->storeAs('covers', $coverFileName, 'public');

        // Создание трека
        $track = Track::create([
            'user_id' => Auth::id(),
            'genre_id' => $genre->id,
            'title' => $validated['title'],
            'cover_image' => $coverPath,
        ]);

        // Привязка файла к треку через полиморфную связь
        $track->files()->create([
            'original_name' => $audioFile->getClientOriginalName(),
            'path' => $audioPath,
            'hash' => md5_file($audioFile->getRealPath()),
            'size' => $audioFile->getSize(),
        ]);

        return redirect()->route('tracks.show', $track)
            ->with('success', 'Трек успешно загружен!');
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        // Валидация
        $request->validate([
            'query' => 'required|string|min:2|max:100',
        ]);

        // Поиск треков
        $tracks = Track::where('title', 'like', "%{$query}%")
            ->orWhereHas('user', function($q) use ($query) {
                $q->where('name', 'like', "%{$query}%");
            })
            ->with('user') // Подгружаем связанного пользователя
            ->limit(10)
            ->get();

        return response()->json([
            'tracks' => $tracks->map(function($track) {
                return [
                    'id' => $track->id,
                    'title' => $track->title,
                    'artist' => $track->user->name,
                    'cover' => $track->cover_image ?? '/images/default-cover.jpg',
                    'url' => $track->file_url,
                ];
            })
        ]);
    }
}
