<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Thread;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class CommentController extends Controller
{
    public function store(Request $request)
    {
        // Валидация данных
        $validated = $request->validate([
            'content' => 'required|string|min:3',
            'thread_id' => 'required|exists:threads,id',
            'track_id' => 'nullable|exists:tracks,id',
            'files.*' => 'nullable|file|max:10240|mimes:zip,rar,pdf,doc,docx,xls,xlsx,mp3,wav,jpg,jpeg,png,gif',
        ]);

        // Создание комментария
        $comment = new Comment();
        $comment->content = $validated['content'];
        $comment->thread_id = $validated['thread_id'];
        $comment->user_id = Auth::id();

        // Прикрепление трека
        if (!empty($validated['track_id'])) {
            $comment->track_id = $validated['track_id'];
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
            'track_id' => 'nullable|exists:tracks,id',
            'files.*' => 'nullable|file|max:10240', // 10MB max per file
            'remove_track' => 'nullable|boolean',
            'remove_files' => 'nullable|string', // comma-separated file IDs
        ]);

        // Обновляем контент
        $comment->content = $request->content;

        // Обработка трека
        if ($request->remove_track == '1') {
            // Удаляем трек
            $comment->track_id = null;
        } elseif ($request->track_id) {
            // Устанавливаем новый трек
            $comment->track_id = $request->track_id;
        }

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
                Storage::delete($file->path);
                $file->delete();
            }
        }

        // Удаляем комментарий
        $comment->delete();

        return redirect()->back()->with('success', 'Комментарий успешно удален');
    }
}