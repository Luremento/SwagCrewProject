<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Thread;
use App\Models\Track;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        // Валидация данных
        $validated = $request->validate([
            'content' => 'required|string|min:3',
            'thread_id' => 'nullable|exists:threads,id',
            'track_id' => 'nullable|exists:tracks,id',
            'files.*' => 'nullable|file|max:10240|mimes:zip,rar,pdf,doc,docx,xls,xlsx,mp3,wav,jpg,jpeg,png,gif',
        ]);

        // Проверяем, что указан либо thread_id, либо track_id, но не оба
        if (empty($validated['thread_id']) && empty($validated['track_id'])) {
            return redirect()->back()
                ->withErrors(['error' => 'Необходимо указать либо тему, либо трек для комментария.']);
        }

        if (!empty($validated['thread_id']) && !empty($validated['track_id'])) {
            return redirect()->back()
                ->withErrors(['error' => 'Комментарий не может быть одновременно к теме и треку.']);
        }

        // Создание комментария
        $comment = new Comment();
        $comment->content = $validated['content'];
        $comment->user_id = Auth::id();

        // Устанавливаем либо thread_id, либо track_id
        if (!empty($validated['thread_id'])) {
            $comment->thread_id = $validated['thread_id'];
            $comment->track_id = null;
        } else {
            $comment->track_id = $validated['track_id'];
            $comment->thread_id = null;
        }

        $comment->save();

        // Обработка загруженных файлов
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $path = $file->store('comment_files', 'public');

                $comment->files()->create([
                    'original_name' => $file->getClientOriginalName(),
                    'path' => $path,
                    'hash' => $file->hashName(),
                    'size' => $file->getSize(),
                    'mime_type' => $file->getMimeType(),
                ]);
            }
        }

        return redirect()->back()
            ->with('success', 'Комментарий успешно добавлен!');
    }

    /**
     * Обновление комментария
     */
    public function update(Request $request, Comment $comment)
    {
        // Проверяем права доступа
        if (Auth::id() !== $comment->user_id && !Auth::user()->hasRole('admin')) {
            abort(403);
        }

        $request->validate([
            'content' => 'required|string',
            'files.*' => 'nullable|file|max:10240', // 10MB max per file
            'remove_files' => 'nullable|string', // comma-separated file IDs
        ]);

        // Обновляем контент
        $comment->content = $request->content;

        // Обработка удаления файлов
        if ($request->remove_files) {
            $fileIdsToRemove = explode(',', $request->remove_files);
            $fileIdsToRemove = array_filter($fileIdsToRemove); // Убираем пустые значения

            if (!empty($fileIdsToRemove)) {
                // Получаем файлы для удаления
                $filesToDelete = $comment->files()->whereIn('id', $fileIdsToRemove)->get();

                foreach ($filesToDelete as $file) {
                    // Удаляем физический файл
                    if (Storage::disk('public')->exists($file->path)) {
                        Storage::disk('public')->delete($file->path);
                    }

                    // Удаляем запись из базы данных
                    $file->delete();
                }
            }
        }

        // Сохраняем изменения комментария
        $comment->save();

        // Обработка новых файлов
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $path = $file->store('comment_files', 'public');

                $comment->files()->create([
                    'original_name' => $file->getClientOriginalName(),
                    'path' => $path,
                    'size' => $file->getSize(),
                    'mime_type' => $file->getMimeType(),
                    'hash' => $file->hashName(),
                ]);
            }
        }

        return redirect()->back()->with('success', 'Комментарий успешно обновлен');
    }

    /**
     * Удаление комментария
     */
    public function destroy(Comment $comment)
    {
        // Проверяем права доступа
        if (Auth::id() !== $comment->user_id && !Auth::user()->hasRole('admin')) {
            abort(403, 'У вас нет прав для удаления этого комментария');
        }

        // Удаляем прикрепленные файлы
        if ($comment->files) {
            foreach ($comment->files as $file) {
                if (Storage::disk('public')->exists($file->path)) {
                    Storage::disk('public')->delete($file->path);
                }
                $file->delete();
            }
        }

        // Удаляем комментарий
        $comment->delete();

        return redirect()->back()->with('success', 'Комментарий успешно удален');
    }

    /**
     * Получить комментарии для темы
     */
    public function getThreadComments($threadId)
    {
        $comments = Comment::where('thread_id', $threadId)
            ->whereNull('track_id')
            ->with(['user', 'files'])
            ->orderBy('created_at', 'asc')
            ->get();

        return $comments;
    }

    /**
     * Получить комментарии для трека
     */
    public function getTrackComments($trackId)
    {
        $comments = Comment::where('track_id', $trackId)
            ->whereNull('thread_id')
            ->with(['user', 'files'])
            ->orderBy('created_at', 'asc')
            ->get();

        return $comments;
    }
}
