<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Category, Thread};

class ForumTopicController extends Controller
{
    public function index(Request $request) {
        $categories = Category::with('threads')->get();

        $query = Thread::with('category', 'tags', 'user', 'comments');

        // Фильтрация по категории
        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Фильтрация по типу сортировки
        if ($request->sort === 'most_commented') {
            $query->withCount('comments')->orderBy('comments_count', 'desc');
        } else {
            $query->latest(); // По умолчанию - новые
        }

        $themes = $query->take(10)->get();

        return view('forum', compact('categories', 'themes'));
    }
}
