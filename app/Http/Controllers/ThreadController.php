<?php

namespace App\Http\Controllers;

use App\Http\Requests\Thread\UpdateThreadRequest;
use App\Http\Requests\Thread\UploadThreadRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Thread;
use App\Models\Tags;
use App\Models\Track;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ThreadController extends Controller
{
    public function create() {
        $categories = Category::all();
        return view('threads.create', compact('categories'));
    }

    /**
     * Сохранение новой темы
     */
    public function store(UploadThreadRequest $request)
    {
        // Валидация данных
        $validated = $request->validated();

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

        return redirect()->route('thread.show', $thread->id)
            ->with('success', 'Тема успешно создана!');
    }

    /**
     * Отображение темы
     */
    public function show($id)
    {
        $thread = Thread::with(['user', 'tags', 'category', 'files', 'track', 'comments.user', 'comments.files', 'comments.track'])
            ->findOrFail($id);

        return view('threads.show', compact('thread'));
    }

    /**
     * Отображение формы редактирования темы
     */
    public function edit($id)
    {
        $thread = Thread::with(['tags', 'files', 'track'])->findOrFail($id);

        // Проверка прав доступа
        if (Auth::id() !== $thread->user_id && !Auth::user()->hasRole('admin')) {
            return redirect()->route('thread.show', $thread->id)
                ->with('error', 'У вас нет прав на редактирование этой темы');
        }

        $categories = Category::all();

        // Подготовка тегов для отображения
        $tagNames = $thread->tags->pluck('name')->implode(', ');

        return view('threads.edit', compact('thread', 'categories', 'tagNames'));
    }

    /**
     * Обновление темы
     */
    public function update(UpdateThreadRequest $request, $id)
    {
        $thread = Thread::findOrFail($id);

        // Проверка прав доступа
        if (Auth::id() !== $thread->user_id && !Auth::user()->hasRole('admin')) {
            return redirect()->route('thread.show', $thread->id)
                ->with('error', 'У вас нет прав на редактирование этой темы');
        }

        // Валидация данных
        $validated = $request->validated();

        // Обновление темы
        $thread->title = $validated['title'];
        $thread->content = $validated['content'];
        $thread->category_id = $validated['category'];

        // Обновление трека
        if (!empty($validated['attached_track_id'])) {
            $track = Track::find($validated['attached_track_id']);
            if ($track) {
                $thread->track_id = $track->id;
            }
        } else {
            $thread->track_id = null;
        }

        $thread->save();

        // Обновление тегов
        $thread->tags()->detach(); // Удаляем все текущие теги

        if (!empty($validated['tags'])) {
            $tagArray = array_map('trim', explode(',', $validated['tags']));
            foreach ($tagArray as $tagName) {
                if (!empty($tagName)) {
                    $tag = Tags::firstOrCreate(['name' => $tagName]);
                    $thread->tags()->attach($tag);
                }
            }
        }

        // Удаление выбранных файлов
        if (!empty($validated['delete_files'])) {
            foreach ($validated['delete_files'] as $fileId) {
                $file = $thread->files()->find($fileId);
                if ($file) {
                    Storage::disk('public')->delete($file->path);
                    $file->delete();
                }
            }
        }

        // Обработка новых загруженных файлов
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $path = $file->store('thread_files', 'public');

                $thread->files()->create([
                    'original_name' => $file->getClientOriginalName(),
                    'path' => $path,
                    'hash' => $file->hashName(),
                    'size' => $file->getSize(),
                ]);
            }
        }

        return redirect()->route('thread.show', $thread->id)
            ->with('success', 'Тема успешно обновлена!');
    }

    /**
     * Удаление темы
     */
    public function destroy($id)
    {
        $thread = Thread::findOrFail($id);

        // Проверка прав доступа
        if (Auth::id() !== $thread->user_id && !Auth::user()->hasRole('admin')) {
            return redirect()->route('thread.show', $thread->id)
                ->with('error', 'У вас нет прав на удаление этой темы');
        }

        // Удаление файлов
        foreach ($thread->files as $file) {
            Storage::disk('public')->delete($file->path);
        }

        // Удаление связей и самой темы
        $thread->tags()->detach();
        $thread->files()->delete();
        $thread->comments()->delete();
        $thread->delete();

        return redirect()->route('forum.index')
            ->with('success', 'Тема успешно удалена!');
    }
}