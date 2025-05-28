<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\Genre;
use App\Models\Track;
use App\Models\Playlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Track\UploadTrackRequest;
use Illuminate\Support\Str;

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
            $tracksQuery->withCount('favorites')->orderByDesc('favorites_count');
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


    /**
     * Display the specified resource.
     */
    public function show(Track $track)
    {
        $track->load(['user', 'genre']);

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

    public function getTrackData($id)
    {
        // Загружаем трек
        $track = Track::findOrFail($id);

        // Получаем файлы напрямую из базы данных
        $file = \DB::table('files')->first();

        // dd($file);

        // Формируем URL к аудиофайлу
        $audioUrl = null;
        if ($file) {
            $audioUrl = asset('storage/' . $file->path);
        }

        return response()->json([
            'id' => $track->id,
            'title' => $track->title,
            'artist' => $track->user->name,
            'cover' => $track->cover_image ? asset('storage/' . $track->cover_image) : null,
            'audio_url' => $audioUrl,
            'genre' => $track->genre->name,
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

        // Валидация
        $request->validate([
            'query' => 'required|string|min:2|max:100',
        ]);

        // Поиск треков
        $tracks = Track::where('title', 'like', "%{$query}%")
            ->orWhereHas('user', function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%");
            })
            ->with('user') // Подгружаем связанного пользователя
            ->limit(10)
            ->get();

        return response()->json([
            'tracks' => $tracks->map(function ($track) {
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

    public function softDelete(Track $track)
    {
        // Проверяем права доступа
        if (Auth::user()->role !== 'admin' && Auth::id() !== $track->user_id) {
            abort(403, 'У вас нет прав для удаления этого трека');
        }

        $trackTitle = $track->title;
        $isAdmin = Auth::user()->role === 'admin';
        $isOwner = Auth::id() === $track->user_id;

        if ($isAdmin) {
            // Администратор удаляет окончательно

            // Проверяем, не удален ли уже трек мягко
            if ($track->trashed()) {
                // Если трек уже в корзине, удаляем окончательно
                return $this->forceDelete($track->id);
            }

            // Удаляем связанные файлы
            $files = $track->files;
            foreach ($files as $file) {
                if (Storage::disk('public')->exists($file->path)) {
                    Storage::disk('public')->delete($file->path);
                }
            }

            // Удаляем обложку
            if ($track->cover_image && Storage::disk('public')->exists($track->cover_image)) {
                Storage::disk('public')->delete($track->cover_image);
            }

            // Окончательное удаление
            $track->forceDelete();

            $message = $isOwner
                ? "Ваш трек \"{$trackTitle}\" окончательно удален"
                : "Трек \"{$trackTitle}\" окончательно удален администратором";

        } else {
            // Пользователь удаляет мягко

            // Проверяем, не удален ли уже трек
            if ($track->trashed()) {
                return redirect()->back()->with('error', 'Трек уже в корзине');
            }

            $track->delete();

            $message = "Ваш трек \"{$trackTitle}\" перемещен в корзину. Вы можете восстановить его в любое время.";
        }

        return redirect()->back()->with('success', $message);
    }

    public function restore($id)
    {
        // Только владелец трека может восстанавливать свои треки
        $track = Track::withTrashed()->findOrFail($id);

        if (Auth::id() !== $track->user_id) {
            abort(403, 'У вас нет прав для восстановления этого трека');
        }

        if (!$track->trashed()) {
            return redirect()->back()->with('error', 'Трек не удален');
        }

        $track->restore();

        return redirect()->back()->with('success', "Ваш трек \"{$track->title}\" успешно восстановлен");
    }

    public function forceDelete($id)
    {
        // Только администраторы могут окончательно удалять треки
        if (Auth::user()->role !== 'admin') {
            abort(403, 'У вас нет прав для окончательного удаления треков');
        }

        $track = Track::withTrashed()->findOrFail($id);

        // Удаляем связанные файлы
        $files = $track->files;
        foreach ($files as $file) {
            if (Storage::disk('public')->exists($file->path)) {
                Storage::disk('public')->delete($file->path);
            }
        }

        // Удаляем обложку
        if ($track->cover_image && Storage::disk('public')->exists($track->cover_image)) {
            Storage::disk('public')->delete($track->cover_image);
        }

        $trackTitle = $track->title;
        $track->forceDelete();

        return redirect()->back()->with('success', "Трек \"{$trackTitle}\" окончательно удален");
    }
}
