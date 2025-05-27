<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Track, Thread, User};

class MainController extends Controller
{
    public function index()
    {
        $track = Track::with('user')->inRandomOrder()->first();

        $popularThreads = Thread::with('user', 'category', 'tags')->withCount('comments')
            ->orderByDesc('comments_count')
            ->take(3)
            ->get();

        // Получаем самые популярные треки по количеству добавлений в избранное
        $popularTracks = Track::with(['user', 'genre', 'favorites'])
            ->withCount('favorites')
            ->orderByDesc('favorites_count')
            ->take(8) // Берем 8 треков для сетки
            ->get();

        return view('index', compact('track', 'popularThreads', 'popularTracks'));
    }

    public function search(Request $request)
    {
        $query = $request->get('q');

        if (empty($query) || strlen($query) < 2) {
            return view('search.results', [
                'query' => $query,
                'users' => collect(),
                'tracks' => collect(),
                'threads' => collect(),
                'totalResults' => 0
            ]);
        }

        // Поиск пользователей
        $users = User::where('name', 'LIKE', "%{$query}%")
            ->orWhere('bio', 'LIKE', "%{$query}%")
            ->withCount(['tracks', 'followers'])
            ->limit(10)
            ->get();

        // Поиск треков
        $tracks = Track::where('title', 'LIKE', "%{$query}%")
            ->orWhereHas('user', function ($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%");
            })
            ->orWhereHas('genre', function ($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%");
            })
            ->with(['user', 'genre'])
            ->withCount('favorites')
            ->limit(10)
            ->get();

        // Поиск тем форума
        $threads = Thread::where('title', 'LIKE', "%{$query}%")
            ->orWhere('content', 'LIKE', "%{$query}%")
            ->orWhereHas('user', function ($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%");
            })
            ->orWhereHas('tags', function ($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%");
            })
            ->with(['user', 'category', 'tags'])
            ->withCount('comments')
            ->limit(10)
            ->get();

        $totalResults = $users->count() + $tracks->count() + $threads->count();

        return view('search.results', compact('query', 'users', 'tracks', 'threads', 'totalResults'));
    }

    public function searchSuggestions(Request $request)
    {
        $query = $request->get('q');

        if (empty($query) || strlen($query) < 2) {
            return response()->json([]);
        }

        $suggestions = [];

        // Быстрые предложения пользователей
        $users = User::where('name', 'LIKE', "%{$query}%")
            ->select('id', 'name', 'avatar')
            ->limit(3)
            ->get();

        foreach ($users as $user) {
            $suggestions[] = [
                'type' => 'user',
                'id' => $user->id,
                'title' => $user->name,
                'subtitle' => 'Пользователь',
                'avatar' => $user->avatar ? asset('storage/avatars/' . $user->avatar) : asset('img/default-avatar.webp'),
                'url' => route('profile.index', $user->id)
            ];
        }

        // Быстрые предложения треков
        $tracks = Track::where('title', 'LIKE', "%{$query}%")
            ->with('user')
            ->select('id', 'title', 'cover_image', 'user_id')
            ->limit(3)
            ->get();

        foreach ($tracks as $track) {
            $suggestions[] = [
                'type' => 'track',
                'id' => $track->id,
                'title' => $track->title,
                'subtitle' => 'Трек от ' . $track->user->name,
                'avatar' => $track->cover_image ? asset('storage/' . $track->cover_image) : null,
                'url' => route('tracks.show', $track->id)
            ];
        }

        // Быстрые предложения тем форума
        $threads = Thread::where('title', 'LIKE', "%{$query}%")
            ->with('user')
            ->select('id', 'title', 'user_id')
            ->limit(3)
            ->get();

        foreach ($threads as $thread) {
            $suggestions[] = [
                'type' => 'thread',
                'id' => $thread->id,
                'title' => $thread->title,
                'subtitle' => 'Тема от ' . $thread->user->name,
                'avatar' => null,
                'url' => route('thread.show', $thread->id)
            ];
        }

        return response()->json($suggestions);
    }
}
