<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Thread;
use Illuminate\Support\Facades\Auth;


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
}
