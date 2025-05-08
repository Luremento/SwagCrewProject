<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Category, Thread};

class ForumTopicController extends Controller
{
    public function index() {
        $categories = Category::with('threads')->get();
        $themes = Thread::with('category', 'tags', 'user')->latest()->take(10)->get();
        return view('forum', compact('categories', 'themes'));
    }
}
