<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Category, Thread};

class ForumTopicController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::with('threads')->get();

        $query = Thread::with('category', 'tags', 'user', 'comments');

        // Поиск по названию и содержимому
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('content', 'LIKE', "%{$searchTerm}%")
                    ->orWhereHas('tags', function ($tagQuery) use ($searchTerm) {
                        $tagQuery->where('name', 'LIKE', "%{$searchTerm}%");
                    })
                    ->orWhereHas('user', function ($userQuery) use ($searchTerm) {
                        $userQuery->where('name', 'LIKE', "%{$searchTerm}%");
                    });
            });
        }

        // Фильтрация по категории
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Фильтрация по типу сортировки
        if ($request->get('sort') === 'most_commented') {
            $query->withCount('comments')->orderByDesc('comments_count');
        } else {
            $query->latest(); // По умолчанию - новые
        }

        // Используем пагинацию вместо take(10)
        $themes = $query->paginate(10)->appends($request->query());

        return view('forum', compact('categories', 'themes'));
    }
}