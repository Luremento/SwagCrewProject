<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Category};
use App\Models\Thread;
use App\Models\ThreadFile;
use App\Models\Track;
use App\Models\Tags;
use App\Models\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ThreadController extends Controller
{
    public function create() {
        $categories = Category::all();
        return view('threads.create', compact('categories'));
    }

    /**
     * Сохранение новой темы
     */
    public function store(Request $request)
    {
        // Валидация данных
        $validated = $request->validate([
            'title' => 'required|string|min:5|max:255',
            'category' => 'required|exists:categories,id',
            'tags' => 'nullable|string|max:255',
            'content' => 'required|string|min:10',
            'attached_track_id' => 'nullable|exists:tracks,id',
            'files.*' => 'nullable|file|max:10240|mimes:zip,rar,pdf,doc,docx,xls,xlsx,mp3,wav,jpg,jpeg,png,gif',
        ]);

        // Создание темы
        $thread = new Thread();
        $thread->title = $validated['title'];
        $thread->content = $validated['content'];
        $thread->category_id = $validated['category'];
        $thread->user_id = Auth::id();

        // Прикрепление трека
        if (!empty($validated['attached_track_id'])) {
            $track = Track::find($validated['attached_track_id']);
            if ($track) {
                $thread->track_id = $track->id;
            }
        }

        $thread->save();

        // Обработка тегов
        if (!empty($validated['tags'])) {
            $tagArray = array_map('trim', explode(',', $validated['tags']));
            foreach ($tagArray as $tagName) {
                $tag = Tags::firstOrCreate(['name' => $tagName]);
                $thread->tags()->attach($tag);
            }
        }

        // Обработка загруженных файлов
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $path = $file->store('thread_files', 'public');

                // Создаем файл через полиморфную связь
                $thread->files()->create([
                    'original_name' => $file->getClientOriginalName(),
                    'path' => $path,
                    'hash' => $file->hashName(),
                    'size' => $file->getSize(),
                ]);
            }
        }

        return redirect()->route('forum.show', $thread->id)
            ->with('success', 'Тема успешно создана!');
    }



    /**
     * Отображение темы
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $thread = Thread::with(['user', 'category', 'files', 'track', 'comments.user', 'comments.files', 'comments.track'])
            ->findOrFail($id);

        return view('forum-show', compact('thread'));
    }
}
