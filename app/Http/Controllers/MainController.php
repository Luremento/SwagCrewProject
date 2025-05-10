<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Track, Thread};

class MainController extends Controller
{
public function index() {
    $track = Track::with('user')->inRandomOrder()->first();

    $popularThreads = Thread::with('user', 'category', 'tags')->withCount('comments')
        ->orderByDesc('comments_count')
        ->take(3)
        ->get();

    return view('index', compact('track', 'popularThreads'));
}
}
