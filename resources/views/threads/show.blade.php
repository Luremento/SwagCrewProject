@extends('layouts.app')

@section('title', $thread->title)

@section('content')
    <div class="mx-auto max-w-7xl px-4 py-8">
        <!-- Навигация -->
        <div class="mb-6">
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="/"
                            class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-primary-600 dark:text-gray-400 dark:hover:text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            Главная
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                            <a href="{{ route('forum.index') }}"
                                class="ml-1 text-sm font-medium text-gray-700 hover:text-primary-600 dark:text-gray-400 dark:hover:text-primary-400 md:ml-2">
                                Форум
                            </a>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                            <span class="ml-1 text-sm font-medium text-gray-500 dark:text-gray-400 md:ml-2">
                                {{ $thread->title }}
                            </span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>

        <!-- Основная тема -->
        <div class="overflow-hidden rounded-xl bg-white shadow-lg dark:bg-gray-800/80 dark:backdrop-blur-sm">
            <div class="p-6">
                <div class="mb-6 flex items-center justify-between">
                    <div class="flex items-center">
                        @if ($thread->user->avatar)
                            <img src="{{ asset('storage/avatars/' . $thread->user->avatar) }}" alt="Аватар"
                                class="mr-3 h-10 w-10 rounded-full">
                        @else
                            <img src="{{ asset('img/default-avatar.webp') }}" alt="Аватар"
                                class="mr-3 h-10 w-10 rounded-full">
                        @endif
                        <div>
                            <a href="#"
                                class="font-medium text-gray-900 hover:text-primary-600 dark:text-white dark:hover:text-primary-400">
                                {{ $thread->user->name }}
                            </a>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                @php
                                    $diffInMinutes = $thread->created_at->diffInMinutes();
                                    $diffInHours = $thread->created_at->diffInHours();
                                    $diffInDays = $thread->created_at->diffInDays();

                                    if ($diffInMinutes < 1) {
                                        echo 'только что';
                                    } elseif ($diffInMinutes < 60) {
                                        echo $diffInMinutes .
                                            ' ' .
                                            trans_choice('минуту|минуты|минут', $diffInMinutes) .
                                            ' назад';
                                    } elseif ($diffInHours < 24) {
                                        echo $diffInHours .
                                            ' ' .
                                            trans_choice('час|часа|часов', $diffInHours) .
                                            ' назад';
                                    } elseif ($diffInDays < 7) {
                                        echo $diffInDays . ' ' . trans_choice('день|дня|дней', $diffInDays) . ' назад';
                                    } else {
                                        echo $thread->created_at->format('d.m.Y в H:i');
                                    }
                                @endphp
                            </p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="flex items-center gap-2">
                            <div
                                class="flex items-center rounded-full bg-primary-50 px-3 py-1 text-primary-600 dark:bg-primary-900/30 dark:text-primary-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="mr-1 h-4 w-4" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                                </svg>
                                <span class="text-sm font-medium">{{ $thread->category->name }}</span>
                            </div>

                            <!-- Добавляем выпадающее меню с действиями -->
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open"
                                    class="rounded-full p-2 text-gray-500 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z" />
                                    </svg>
                                </button>

                                <!-- Выпадающее меню -->
                                <div x-show="open" @click.away="open = false"
                                    class="absolute right-0 mt-2 w-48 rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 dark:bg-gray-800 dark:ring-gray-700">
                                    @if (Auth::id() === $thread->user_id || (Auth::check() && Auth::user()->role === 'admin'))
                                        <a href="{{ route('thread.edit', $thread->id) }}"
                                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700">
                                            <div class="flex items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 h-4 w-4" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                                Редактировать
                                            </div>
                                        </a>
                                        <form action="{{ route('thread.destroy', $thread->id) }}" method="POST"
                                            class="delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button"
                                                class="delete-thread-btn block w-full px-4 py-2 text-left text-sm text-red-600 hover:bg-gray-100 dark:text-red-400 dark:hover:bg-gray-700">
                                                <div class="flex items-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 h-4 w-4"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                    Удалить
                                                </div>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <h1 class="mb-4 text-2xl font-bold text-gray-900 dark:text-white">
                    {{ $thread->title }}
                </h1>
                <div class="mb-6 flex flex-wrap gap-2">
                    @foreach ($thread->tags as $tag)
                        <span
                            class="rounded-full bg-gray-100 px-3 py-1 text-xs font-medium text-gray-700 dark:bg-gray-700 dark:text-gray-300">
                            {{ $tag->name }}
                        </span>
                    @endforeach
                </div>

                <!-- Прикрепленный трек -->
                @if ($thread->track)
                    <div
                        class="mb-6 overflow-hidden rounded-lg border border-gray-200 bg-gradient-to-r from-gray-50 to-white p-4 shadow-sm dark:border-gray-700 dark:from-gray-800/80 dark:to-gray-800/60 dark:backdrop-blur-sm">
                        <div class="flex flex-col sm:flex-row sm:items-center">
                            <div
                                class="relative mb-4 mr-0 h-24 w-24 flex-shrink-0 overflow-hidden rounded-lg bg-gray-200 shadow-md dark:bg-gray-700 sm:mb-0 sm:mr-5 sm:h-28 sm:w-28">
                                @if ($thread->track->cover_image)
                                    <img src="{{ asset('storage/' . $thread->track->cover_image) }}" alt="Обложка трека"
                                        class="h-full w-full object-cover">
                                @else
                                    <div
                                        class="flex h-full w-full items-center justify-center bg-gradient-to-br from-gray-300 to-gray-200 dark:from-gray-600 dark:to-gray-700">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-500"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
                                        </svg>
                                    </div>
                                @endif
                                <button data-track-id="{{ $thread->track->id }}"
                                    class="play-button absolute inset-0 flex items-center justify-center bg-black bg-opacity-40 opacity-0 transition-all duration-200 hover:bg-opacity-60 hover:opacity-100">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-white drop-shadow-lg"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </button>
                            </div>
                            <div class="flex-1">
                                <h3 class="mb-1 text-xl font-bold text-gray-900 dark:text-white">
                                    {{ $thread->track->title }}</h3>
                                <p class="mb-3 text-sm text-gray-600 dark:text-gray-300">{{ $thread->track->user->name }}
                                </p>
                                <div class="flex items-center">
                                    <button data-track-id="{{ $thread->track->id }}"
                                        class="play-button mr-3 flex h-10 w-10 items-center justify-center rounded-full bg-primary-600 text-white shadow-md transition-all hover:bg-primary-700 dark:bg-primary-700 dark:hover:bg-primary-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                        </svg>
                                    </button>
                                    <div class="flex-1">
                                        <div
                                            class="mb-1 h-2 w-full overflow-hidden rounded-full bg-gray-200 dark:bg-gray-700">
                                            <div
                                                class="h-full w-0 rounded-full bg-primary-600 dark:bg-primary-500 progress-bar">
                                            </div>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-xs text-gray-500 dark:text-gray-400 track-time">0:00</span>
                                            <span
                                                class="text-xs text-gray-500 dark:text-gray-400 track-duration">0:00</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Прикрепленные файлы -->
                @if ($thread->files && $thread->files->count() > 0)
                    <div
                        class="mb-6 rounded-lg border border-gray-200 bg-gray-50/50 p-4 backdrop-blur-sm dark:border-gray-700/50 dark:bg-gray-800/30">
                        <h3 class="mb-3 flex items-center text-sm font-medium text-gray-900 dark:text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 h-4 w-4" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                            </svg>
                            Прикрепленные файлы
                        </h3>
                        <div class="grid gap-2 sm:grid-cols-2">
                            @foreach ($thread->files as $file)
                                @php
                                    $extension = pathinfo($file->original_name, PATHINFO_EXTENSION);
                                    $icon = 'document';
                                    $bgColor = 'bg-gray-100';
                                    $iconColor = 'text-gray-500';

                                    if (in_array($extension, ['mp3', 'wav', 'ogg'])) {
                                        $icon = 'music';
                                        $bgColor = 'bg-purple-100';
                                        $iconColor = 'text-purple-500';
                                    } elseif (in_array($extension, ['jpg', 'jpeg', 'png', 'gif'])) {
                                        $icon = 'image';
                                        $bgColor = 'bg-blue-100';
                                        $iconColor = 'text-blue-500';
                                    } elseif (in_array($extension, ['zip', 'rar'])) {
                                        $icon = 'archive';
                                        $bgColor = 'bg-amber-100';
                                        $iconColor = 'text-amber-500';
                                    } elseif (in_array($extension, ['pdf'])) {
                                        $icon = 'pdf';
                                        $bgColor = 'bg-red-100';
                                        $iconColor = 'text-red-500';
                                    }
                                @endphp

                                <div
                                    class="flex items-center rounded-lg bg-white p-3 shadow-sm transition-all hover:shadow-md dark:bg-gray-700">
                                    <div
                                        class="mr-3 flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-full {{ $bgColor }} dark:bg-opacity-20">
                                        @if ($icon == 'music')
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="h-5 w-5 {{ $iconColor }} dark:text-opacity-80" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
                                            </svg>
                                        @elseif ($icon == 'image')
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="h-5 w-5 {{ $iconColor }} dark:text-opacity-80" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        @elseif ($icon == 'archive')
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="h-5 w-5 {{ $iconColor }} dark:text-opacity-80" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                                            </svg>
                                        @elseif ($icon == 'pdf')
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="h-5 w-5 {{ $iconColor }} dark:text-opacity-80" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                            </svg>
                                        @else
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="h-5 w-5 {{ $iconColor }} dark:text-opacity-80" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                        @endif
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="truncate text-sm font-medium text-gray-700 dark:text-gray-300">
                                            {{ $file->original_name }}</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">
                                            {{ number_format($file->size / 1024, 1) }} KB</p>
                                    </div>
                                    <a href="{{ asset('storage/' . $file->path) }}"
                                        download="{{ $file->original_name }}"
                                        class="ml-2 flex h-8 w-8 items-center justify-center rounded-full text-gray-500 hover:bg-gray-100 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                        </svg>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="prose max-w-none dark:prose-invert">
                    {!! $thread->content !!}
                </div>
            </div>
        </div>

        <!-- Комментарии -->
        <div class="mt-8">
            <h2 class="mb-4 flex items-center text-xl font-bold text-gray-900 dark:text-white">
                <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 h-5 w-5 text-gray-600 dark:text-gray-400"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                </svg>
                Комментарии <span
                    class="ml-2 rounded-full bg-gray-100 px-2.5 py-0.5 text-sm text-gray-700 dark:bg-gray-700 dark:text-gray-300">{{ $thread->comments->count() }}</span>
            </h2>

            <div class="space-y-4">
                <!-- Комментарии -->
                @foreach ($thread->comments as $comment)
                    <div id="comment-{{ $comment->id }}"
                        class="rounded-lg bg-white p-4 shadow-sm transition-all hover:shadow-md dark:bg-gray-800/80 dark:backdrop-blur-sm">
                        <div class="mb-2 flex items-center justify-between">
                            <div class="flex items-center">
                                @if ($comment->user->avatar)
                                    <img src="{{ asset('storage/avatars/' . $comment->user->avatar) }}" alt="Аватар"
                                        class="mr-3 h-8 w-8 rounded-full border-2 border-white shadow-sm dark:border-gray-700">
                                @else
                                    <img src="{{ asset('img/default-avatar.webp') }}" alt="Аватар"
                                        class="mr-3 h-8 w-8 rounded-full border-2 border-white shadow-sm dark:border-gray-700">
                                @endif
                                <div>
                                    <a href="#"
                                        class="text-sm font-medium text-gray-900 hover:text-primary-600 dark:text-white dark:hover:text-primary-400">
                                        {{ $comment->user->name }}
                                    </a>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">
                                        @php
                                            $diffInMinutes = $comment->created_at->diffInMinutes();
                                            $diffInHours = $comment->created_at->diffInHours();
                                            $diffInDays = $comment->created_at->diffInDays();

                                            if ($diffInMinutes < 1) {
                                                echo 'только что';
                                            } elseif ($diffInMinutes < 60) {
                                                echo $diffInMinutes .
                                                    ' ' .
                                                    trans_choice('минуту|минуты|минут', $diffInMinutes) .
                                                    ' назад';
                                            } elseif ($diffInHours < 24) {
                                                echo $diffInHours .
                                                    ' ' .
                                                    trans_choice('час|часа|часов', $diffInHours) .
                                                    ' назад';
                                            } elseif ($diffInDays < 7) {
                                                echo $diffInDays .
                                                    ' ' .
                                                    trans_choice('день|дня|дней', $diffInDays) .
                                                    ' назад';
                                            } else {
                                                echo $comment->created_at->format('d.m.Y в H:i');
                                            }
                                        @endphp
                                        @if ($comment->updated_at != $comment->created_at)
                                            <span class="text-gray-400">(изменено)</span>
                                        @endif
                                    </p>
                                </div>
                            </div>

                            <!-- Меню действий для комментария -->
                            @if (Auth::id() === $comment->user_id || (Auth::check() && Auth::user()->hasRole('admin')))
                                <div class="relative" x-data="{ open: false }">
                                    <button @click="open = !open"
                                        class="rounded-full p-1 text-gray-500 hover:bg-gray-100 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z" />
                                        </svg>
                                    </button>

                                    <!-- Выпадающее меню для комментария -->
                                    <div x-show="open" @click.away="open = false"
                                        class="absolute right-0 mt-2 w-40 rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 dark:bg-gray-800 dark:ring-gray-700 z-10">
                                        <button type="button" onclick="editComment({{ $comment->id }})"
                                            class="block w-full px-4 py-2 text-left text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700">
                                            <div class="flex items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 h-4 w-4"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                                Редактировать
                                            </div>
                                        </button>
                                        <form action="{{ route('comments.destroy', $comment->id) }}" method="POST"
                                            class="delete-comment-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button"
                                                class="delete-comment-btn block w-full px-4 py-2 text-left text-sm text-red-600 hover:bg-gray-100 dark:text-red-400 dark:hover:bg-gray-700">
                                                <div class="flex items-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 h-4 w-4"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                    Удалить
                                                </div>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- Прикрепленный трек в комментарии -->
                        @if ($comment->track)
                            <div
                                class="mb-3 rounded-lg border border-gray-200 bg-gradient-to-r from-gray-50 to-white p-3 shadow-sm dark:border-gray-700 dark:from-gray-800/50 dark:to-gray-800/30">
                                <div class="flex items-center">
                                    <div class="mr-3 flex-shrink-0">
                                        <div
                                            class="relative h-12 w-12 overflow-hidden rounded-lg bg-gray-200 shadow-sm dark:bg-gray-600">
                                            @if ($comment->track->cover_image)
                                                <img src="{{ asset('storage/' . $comment->track->cover_image) }}"
                                                    alt="Обложка трека" class="h-full w-full object-cover">
                                            @else
                                                <div
                                                    class="flex h-full w-full items-center justify-center bg-gradient-to-br from-gray-300 to-gray-200 dark:from-gray-600 dark:to-gray-700">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-500"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
                                                    </svg>
                                                </div>
                                            @endif
                                            <button data-track-id="{{ $comment->track->id }}"
                                                class="play-button absolute inset-0 flex items-center justify-center bg-black bg-opacity-40 opacity-0 transition-all duration-200 hover:bg-opacity-60 hover:opacity-100">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h4 class="truncate text-sm font-semibold text-gray-900 dark:text-white">
                                            {{ $comment->track->title }}</h4>
                                        <p class="text-xs text-gray-600 dark:text-gray-400">
                                            {{ $comment->track->user->name }}</p>
                                        <div class="mt-2 flex items-center">
                                            <button data-track-id="{{ $comment->track->id }}"
                                                class="play-button mr-2 flex h-6 w-6 items-center justify-center rounded-full bg-primary-600 text-white shadow-sm transition-all hover:bg-primary-700 dark:bg-primary-700 dark:hover:bg-primary-600">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                                </svg>
                                            </button>
                                            <div class="flex-1">
                                                <div
                                                    class="h-1 w-full overflow-hidden rounded-full bg-gray-200 dark:bg-gray-600">
                                                    <div
                                                        class="h-full w-0 rounded-full bg-primary-600 dark:bg-primary-500 progress-bar">
                                                    </div>
                                                </div>
                                            </div>
                                            <span
                                                class="ml-2 text-xs text-gray-500 dark:text-gray-400 track-time">0:00</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Контент комментария -->
                        <div class="comment-content prose prose-sm max-w-none dark:prose-invert">
                            {!! $comment->content !!}
                        </div>

                        <!-- Форма редактирования комментария (скрыта по умолчанию) -->
                        <div class="comment-edit-form hidden mt-4">
                            <form action="{{ route('comments.update', $comment->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="space-y-4">
                                    <textarea name="content" rows="3"
                                        class="w-full rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white"
                                        required>{{ strip_tags($comment->content) }}</textarea>

                                    <!-- Текущий прикрепленный трек -->
                                    @if ($comment->track)
                                        <div class="current-track-container">
                                            <div
                                                class="rounded-lg border border-gray-200 bg-gradient-to-r from-blue-50 to-indigo-50 p-3 dark:border-gray-700 dark:from-gray-800/50 dark:to-gray-800/30">
                                                <div class="flex items-center justify-between">
                                                    <div class="flex items-center">
                                                        <div
                                                            class="mr-3 h-10 w-10 flex-shrink-0 overflow-hidden rounded-lg bg-gray-200 dark:bg-gray-700">
                                                            @if ($comment->track->cover_image)
                                                                <img src="{{ asset('storage/' . $comment->track->cover_image) }}"
                                                                    alt="Обложка трека"
                                                                    class="h-full w-full object-cover">
                                                            @else
                                                                <div
                                                                    class="flex h-full w-full items-center justify-center">
                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                        class="h-5 w-5 text-gray-500" fill="none"
                                                                        viewBox="0 0 24 24" stroke="currentColor">
                                                                        <path stroke-linecap="round"
                                                                            stroke-linejoin="round" stroke-width="2"
                                                                            d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
                                                                    </svg>
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <div>
                                                            <p class="text-sm font-medium text-gray-900 dark:text-white">
                                                                {{ $comment->track->title }}</p>
                                                            <p class="text-xs text-gray-600 dark:text-gray-400">
                                                                {{ $comment->track->user->name }}</p>
                                                        </div>
                                                    </div>
                                                    <button type="button"
                                                        class="remove-current-track flex h-8 w-8 items-center justify-center rounded-full bg-red-100 text-red-600 hover:bg-red-200 dark:bg-red-900/30 dark:text-red-400 dark:hover:bg-red-900/50">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    <!-- Текущие прикрепленные файлы -->
                                    @if ($comment->files && $comment->files->count() > 0)
                                        <div class="current-files-container">
                                            <h4 class="mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                                                Прикрепленные файлы:</h4>
                                            <div class="space-y-2">
                                                @foreach ($comment->files as $file)
                                                    @php
                                                        $extension = pathinfo($file->original_name, PATHINFO_EXTENSION);
                                                        $icon = 'document';
                                                        $bgColor = 'bg-gray-100';
                                                        $iconColor = 'text-gray-500';

                                                        if (in_array($extension, ['mp3', 'wav', 'ogg'])) {
                                                            $icon = 'music';
                                                            $bgColor = 'bg-purple-100';
                                                            $iconColor = 'text-purple-500';
                                                        } elseif (in_array($extension, ['jpg', 'jpeg', 'png', 'gif'])) {
                                                            $icon = 'image';
                                                            $bgColor = 'bg-blue-100';
                                                            $iconColor = 'text-blue-500';
                                                        } elseif (in_array($extension, ['zip', 'rar'])) {
                                                            $icon = 'archive';
                                                            $bgColor = 'bg-amber-100';
                                                            $iconColor = 'text-amber-500';
                                                        } elseif (in_array($extension, ['pdf'])) {
                                                            $icon = 'pdf';
                                                            $bgColor = 'bg-red-100';
                                                            $iconColor = 'text-red-500';
                                                        }
                                                    @endphp

                                                    <div class="current-file-item flex items-center justify-between rounded-lg border border-gray-200 bg-white p-2 shadow-sm dark:border-gray-700 dark:bg-gray-800"
                                                        data-file-id="{{ $file->id }}">
                                                        <div class="flex items-center">
                                                            <div
                                                                class="mr-3 flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-full {{ $bgColor }} dark:bg-opacity-20">
                                                                @if ($icon == 'music')
                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                        class="h-4 w-4 {{ $iconColor }} dark:text-opacity-80"
                                                                        fill="none" viewBox="0 0 24 24"
                                                                        stroke="currentColor">
                                                                        <path stroke-linecap="round"
                                                                            stroke-linejoin="round" stroke-width="2"
                                                                            d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
                                                                    </svg>
                                                                @elseif ($icon == 'image')
                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                        class="h-4 w-4 {{ $iconColor }} dark:text-opacity-80"
                                                                        fill="none" viewBox="0 0 24 24"
                                                                        stroke="currentColor">
                                                                        <path stroke-linecap="round"
                                                                            stroke-linejoin="round" stroke-width="2"
                                                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                                    </svg>
                                                                @elseif ($icon == 'archive')
                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                        class="h-4 w-4 {{ $iconColor }} dark:text-opacity-80"
                                                                        fill="none" viewBox="0 0 24 24"
                                                                        stroke="currentColor">
                                                                        <path stroke-linecap="round"
                                                                            stroke-linejoin="round" stroke-width="2"
                                                                            d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                                                                    </svg>
                                                                @elseif ($icon == 'pdf')
                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                        class="h-4 w-4 {{ $iconColor }} dark:text-opacity-80"
                                                                        fill="none" viewBox="0 0 24 24"
                                                                        stroke="currentColor">
                                                                        <path stroke-linecap="round"
                                                                            stroke-linejoin="round" stroke-width="2"
                                                                            d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                                                    </svg>
                                                                @else
                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                        class="h-4 w-4 {{ $iconColor }} dark:text-opacity-80"
                                                                        fill="none" viewBox="0 0 24 24"
                                                                        stroke="currentColor">
                                                                        <path stroke-linecap="round"
                                                                            stroke-linejoin="round" stroke-width="2"
                                                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                                    </svg>
                                                                @endif
                                                            </div>
                                                            <div>
                                                                <p
                                                                    class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                                                    {{ $file->original_name }}</p>
                                                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                                                    {{ number_format($file->size / 1024, 1) }} KB</p>
                                                            </div>
                                                        </div>
                                                        <button type="button"
                                                            class="remove-current-file flex h-6 w-6 items-center justify-center rounded-full bg-red-100 text-red-600 hover:bg-red-200 dark:bg-red-900/30 dark:text-red-400 dark:hover:bg-red-900/50">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3"
                                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                            </svg>
                                                        </button>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif

                                    <!-- Добавление новых вложений -->
                                    <div class="flex flex-wrap items-center gap-3">
                                        <!-- Прикрепить трек -->
                                        <button type="button"
                                            class="edit-attach-track-btn flex items-center rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-700 shadow-sm transition-all hover:bg-gray-50 hover:shadow dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:hover:bg-gray-600"
                                            data-comment-id="{{ $comment->id }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 h-4 w-4" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
                                            </svg>
                                            Добавить трек
                                        </button>

                                        <!-- Прикрепить файлы -->
                                        <label for="edit-comment-files-{{ $comment->id }}"
                                            class="flex items-center rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-700 shadow-sm transition-all hover:bg-gray-50 hover:shadow dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:hover:bg-gray-600">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 h-4 w-4" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                                            </svg>
                                            Добавить файлы
                                        </label>
                                        <input type="file" id="edit-comment-files-{{ $comment->id }}" name="files[]"
                                            multiple class="hidden">
                                    </div>

                                    <!-- Скрытые поля для удаления -->
                                    <input type="hidden" name="track_id" class="edit-track-id"
                                        value="{{ $comment->track_id ?? '' }}">
                                    <input type="hidden" name="remove_track" class="remove-track-input" value="0">
                                    <input type="hidden" name="remove_files" class="remove-files-input" value="">

                                    <!-- Контейнеры для новых вложений -->
                                    <div class="edit-selected-track-container hidden"></div>
                                    <div class="edit-comment-files-list hidden"></div>

                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-2">
                                            <button type="submit"
                                                class="rounded-lg bg-primary-600 px-4 py-2 text-sm font-medium text-white shadow-sm transition-all hover:bg-primary-700 focus:outline-none focus:ring-4 focus:ring-primary-300 dark:bg-primary-700 dark:hover:bg-primary-600">
                                                Сохранить
                                            </button>
                                            <button type="button" onclick="cancelEdit({{ $comment->id }})"
                                                class="rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm transition-all hover:bg-gray-50 focus:outline-none focus:ring-4 focus:ring-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:hover:bg-gray-600">
                                                Отмена
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <!-- Прикрепленные файлы в комментарии -->
                        @if ($comment->files && $comment->files->count() > 0)
                            <div
                                class="mt-3 rounded-lg border border-gray-200 bg-gray-50/50 p-3 dark:border-gray-700 dark:bg-gray-700/50">
                                <h4 class="mb-2 text-xs font-medium text-gray-700 dark:text-gray-300">Прикрепленные файлы:
                                </h4>
                                <div class="grid gap-2 sm:grid-cols-2">
                                    @foreach ($comment->files as $file)
                                        @php
                                            $extension = pathinfo($file->original_name, PATHINFO_EXTENSION);
                                            $icon = 'document';
                                            $bgColor = 'bg-gray-100';
                                            $iconColor = 'text-gray-500';

                                            if (in_array($extension, ['mp3', 'wav', 'ogg'])) {
                                                $icon = 'music';
                                                $bgColor = 'bg-purple-100';
                                                $iconColor = 'text-purple-500';
                                            } elseif (in_array($extension, ['jpg', 'jpeg', 'png', 'gif'])) {
                                                $icon = 'image';
                                                $bgColor = 'bg-blue-100';
                                                $iconColor = 'text-blue-500';
                                            } elseif (in_array($extension, ['zip', 'rar'])) {
                                                $icon = 'archive';
                                                $bgColor = 'bg-amber-100';
                                                $iconColor = 'text-amber-500';
                                            } elseif (in_array($extension, ['pdf'])) {
                                                $icon = 'pdf';
                                                $bgColor = 'bg-red-100';
                                                $iconColor = 'text-red-500';
                                            }
                                        @endphp

                                        <div
                                            class="flex items-center rounded-lg bg-white p-2 shadow-sm transition-all hover:shadow-md dark:bg-gray-800">
                                            <div
                                                class="mr-2 flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-full {{ $bgColor }} dark:bg-opacity-20">
                                                @if ($icon == 'music')
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="h-4 w-4 {{ $iconColor }} dark:text-opacity-80"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
                                                    </svg>
                                                @elseif ($icon == 'image')
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="h-4 w-4 {{ $iconColor }} dark:text-opacity-80"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                    </svg>
                                                @elseif ($icon == 'archive')
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="h-4 w-4 {{ $iconColor }} dark:text-opacity-80"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                                                    </svg>
                                                @elseif ($icon == 'pdf')
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="h-4 w-4 {{ $iconColor }} dark:text-opacity-80"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                                    </svg>
                                                @else
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="h-4 w-4 {{ $iconColor }} dark:text-opacity-80"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                    </svg>
                                                @endif
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p class="truncate text-sm font-medium text-gray-700 dark:text-gray-300">
                                                    {{ Str::limit($file->original_name, 20) }}</p>
                                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                                    {{ number_format($file->size / 1024, 1) }} KB</p>
                                            </div>
                                            <a href="{{ asset('storage/' . $file->path) }}"
                                                download="{{ $file->original_name }}"
                                                class="ml-2 flex h-6 w-6 items-center justify-center rounded-full text-gray-500 hover:bg-gray-100 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                                </svg>
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                @endforeach

                <!-- Форма добавления комментария -->
                <div class="sticky bottom-0 rounded-lg bg-white p-4 shadow-lg dark:bg-gray-800/90 dark:backdrop-blur-sm">
                    <form action="{{ route('comments.store') }}" method="POST" enctype="multipart/form-data"
                        class="space-y-3">
                        @csrf
                        <input type="hidden" name="thread_id" value="{{ $thread->id }}">

                        <div class="flex items-center gap-2">
                            <textarea name="content" rows="1"
                                class="flex-1 rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white"
                                placeholder="Напишите ваш комментарий..." required></textarea>

                            <button type="submit"
                                class="rounded-lg bg-primary-600 px-3 py-2 text-sm font-medium text-white shadow-sm transition-all hover:bg-primary-700 hover:shadow focus:outline-none focus:ring-4 focus:ring-primary-300 dark:bg-primary-700 dark:hover:bg-primary-600 dark:focus:ring-primary-800">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                                </svg>
                            </button>
                        </div>

                        <div class="flex flex-wrap items-center gap-3">
                            <!-- Прикрепить трек к комментарию -->
                            <button type="button" id="attach-track-btn"
                                class="flex items-center rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-700 shadow-sm transition-all hover:bg-gray-50 hover:shadow dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:hover:bg-gray-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 h-4 w-4" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
                                </svg>
                                Прикрепить трек
                            </button>
                            <input type="hidden" name="track_id" id="comment-track-id">
                            <div id="selected-track-container" class="hidden"></div>

                            <!-- Прикрепить файлы к комментарию -->
                            <label for="comment-files"
                                class="flex items-center rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-700 shadow-sm transition-all hover:bg-gray-50 hover:shadow dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:hover:bg-gray-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 h-4 w-4" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                                </svg>
                                Прикрепить файлы
                            </label>
                            <input type="file" id="comment-files" name="files[]" multiple class="hidden">
                            <div id="comment-files-list" class="hidden"></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Функция для редактирования комментария
        function editComment(commentId) {
            const commentElement = document.getElementById(`comment-${commentId}`);
            const contentElement = commentElement.querySelector('.comment-content');
            const editForm = commentElement.querySelector('.comment-edit-form');

            // Скрываем контент и показываем форму редактирования
            contentElement.style.display = 'none';
            editForm.classList.remove('hidden');

            // Фокусируемся на textarea
            const textarea = editForm.querySelector('textarea');
            textarea.focus();

            // Устанавливаем курсор в конец текста
            textarea.setSelectionRange(textarea.value.length, textarea.value.length);
        }

        // Функция для отмены редактирования
        function cancelEdit(commentId) {
            const commentElement = document.getElementById(`comment-${commentId}`);
            const contentElement = commentElement.querySelector('.comment-content');
            const editForm = commentElement.querySelector('.comment-edit-form');

            // Показываем контент и скрываем форму редактирования
            contentElement.style.display = 'block';
            editForm.classList.add('hidden');

            // Сбрасываем состояние формы
            const removeTrackInput = editForm.querySelector('.remove-track-input');
            const removeFilesInput = editForm.querySelector('.remove-files-input');
            const currentTrackContainer = editForm.querySelector('.current-track-container');
            const currentFilesContainer = editForm.querySelector('.current-files-container');

            if (removeTrackInput) removeTrackInput.value = '0';
            if (removeFilesInput) removeFilesInput.value = '';
            if (currentTrackContainer) currentTrackContainer.style.display = 'block';
            if (currentFilesContainer) {
                currentFilesContainer.querySelectorAll('.current-file-item').forEach(item => {
                    item.style.display = 'flex';
                });
            }

            // Очищаем новые вложения
            const newTrackContainer = editForm.querySelector('.edit-selected-track-container');
            const newFilesContainer = editForm.querySelector('.edit-comment-files-list');
            if (newTrackContainer) {
                newTrackContainer.classList.add('hidden');
                newTrackContainer.innerHTML = '';
            }
            if (newFilesContainer) {
                newFilesContainer.classList.add('hidden');
                newFilesContainer.innerHTML = '';
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Обработка удаления комментариев с подтверждением
            const deleteCommentButtons = document.querySelectorAll('.delete-comment-btn');
            deleteCommentButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    if (confirm('Вы уверены, что хотите удалить этот комментарий?')) {
                        this.closest('form').submit();
                    }
                });
            });

            // Обработка удаления темы с подтверждением
            const deleteButtons = document.querySelectorAll('.delete-thread-btn');
            deleteButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    if (confirm('Вы уверены, что хотите удалить эту тему?')) {
                        this.closest('form').submit();
                    }
                });
            });

            // Обработка удаления текущего трека в форме редактирования
            document.addEventListener('click', function(e) {
                if (e.target.closest('.remove-current-track')) {
                    const editForm = e.target.closest('.comment-edit-form');
                    const currentTrackContainer = editForm.querySelector('.current-track-container');
                    const removeTrackInput = editForm.querySelector('.remove-track-input');
                    const trackIdInput = editForm.querySelector('.edit-track-id');

                    currentTrackContainer.style.display = 'none';
                    removeTrackInput.value = '1';
                    trackIdInput.value = '';
                }
            });

            // Обработка удаления текущих файлов в форме редактирования
            document.addEventListener('click', function(e) {
                if (e.target.closest('.remove-current-file')) {
                    const fileItem = e.target.closest('.current-file-item');
                    const fileId = fileItem.dataset.fileId;
                    const editForm = e.target.closest('.comment-edit-form');
                    const removeFilesInput = editForm.querySelector('.remove-files-input');

                    fileItem.style.display = 'none';

                    // Добавляем ID файла к списку удаляемых
                    let removeFiles = removeFilesInput.value ? removeFilesInput.value.split(',') : [];
                    if (!removeFiles.includes(fileId)) {
                        removeFiles.push(fileId);
                        removeFilesInput.value = removeFiles.join(',');
                    }
                }
            });

            // Обработка прикрепления треков в форме редактирования
            document.addEventListener('click', function(e) {
                if (e.target.closest('.edit-attach-track-btn')) {
                    const button = e.target.closest('.edit-attach-track-btn');
                    const commentId = button.dataset.commentId;
                    const editForm = button.closest('.comment-edit-form');
                    const selectedTrackContainer = editForm.querySelector('.edit-selected-track-container');
                    const trackIdInput = editForm.querySelector('.edit-track-id');

                    // Создаем поиск треков для редактирования
                    if (!editForm.querySelector('.edit-track-search')) {
                        const searchContainer = document.createElement('div');
                        searchContainer.className = 'mt-3 space-y-2';
                        searchContainer.innerHTML = `
                            <div class="relative">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </div>
                                <input type="text" class="edit-track-search block w-full rounded-lg border border-gray-200 bg-gray-50 p-2 pl-10 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white" placeholder="Поиск трека по названию...">
                            </div>
                            <div class="edit-track-results hidden rounded-lg border border-gray-200 bg-white dark:border-gray-700 dark:bg-gray-800">
                                <div class="max-h-40 overflow-y-auto p-2">
                                    <!-- Results will appear here -->
                                </div>
                            </div>
                        `;

                        selectedTrackContainer.parentNode.insertBefore(searchContainer,
                            selectedTrackContainer);

                        const trackSearch = searchContainer.querySelector('.edit-track-search');
                        const trackResults = searchContainer.querySelector('.edit-track-results');

                        trackSearch.focus();

                        let searchTimeout;
                        trackSearch.addEventListener('input', function() {
                            clearTimeout(searchTimeout);

                            if (this.value.length > 2) {
                                searchTimeout = setTimeout(() => {
                                    fetch(
                                            `/theme/track/search?query=${encodeURIComponent(this.value)}`
                                        )
                                        .then(response => response.json())
                                        .then(data => {
                                            trackResults.querySelector('div')
                                                .innerHTML = '';

                                            if (data.tracks && data.tracks.length > 0) {
                                                data.tracks.forEach(track => {
                                                    const trackElement =
                                                        document.createElement(
                                                            'div');
                                                    trackElement.className =
                                                        'track-result cursor-pointer rounded-lg p-2 hover:bg-gray-100 dark:hover:bg-gray-700';
                                                    trackElement.dataset.id =
                                                        track.id;
                                                    trackElement.dataset.title =
                                                        track.title;
                                                    trackElement.dataset
                                                        .artist = track.artist;
                                                    trackElement.dataset.cover =
                                                        track.cover;

                                                    const storageBaseUrl =
                                                        "{{ asset('storage') }}";
                                                    trackElement.innerHTML = `
                                                        <div class="flex items-center">
                                                            <div class="mr-2 h-8 w-8 flex-shrink-0 overflow-hidden rounded-md bg-gray-200 dark:bg-gray-700">
                                                                <img src="${storageBaseUrl + '/' + track.cover}" alt="Обложка трека" class="h-full w-full object-cover">
                                                            </div>
                                                            <div>
                                                                <p class="text-xs font-medium text-gray-900 dark:text-white">${track.title}</p>
                                                                <p class="text-xs text-gray-500 dark:text-gray-400">${track.artist}</p>
                                                            </div>
                                                        </div>
                                                    `;

                                                    trackElement
                                                        .addEventListener(
                                                            'click',
                                                            function() {
                                                                selectEditTrack(
                                                                    this
                                                                    .dataset
                                                                    .id,
                                                                    this
                                                                    .dataset
                                                                    .title,
                                                                    this
                                                                    .dataset
                                                                    .artist,
                                                                    this
                                                                    .dataset
                                                                    .cover,
                                                                    editForm
                                                                );
                                                            });

                                                    trackResults.querySelector(
                                                        'div').appendChild(
                                                        trackElement);
                                                });

                                                trackResults.classList.remove('hidden');
                                            } else {
                                                const noResults = document
                                                    .createElement('div');
                                                noResults.className =
                                                    'p-2 text-center text-xs text-gray-500 dark:text-gray-400';
                                                noResults.textContent =
                                                    'Треки не найдены';
                                                trackResults.querySelector('div')
                                                    .appendChild(noResults);
                                                trackResults.classList.remove('hidden');
                                            }
                                        })
                                        .catch(error => {
                                            console.error('Ошибка при поиске треков:',
                                                error);
                                        });
                                }, 300);
                            } else {
                                trackResults.classList.add('hidden');
                            }
                        });
                    } else {
                        editForm.querySelector('.edit-track-search').focus();
                    }
                }
            });

            // Функция выбора трека для редактирования
            function selectEditTrack(id, title, artist, cover, editForm) {
                const trackIdInput = editForm.querySelector('.edit-track-id');
                const selectedTrackContainer = editForm.querySelector('.edit-selected-track-container');

                trackIdInput.value = id;
                selectedTrackContainer.classList.remove('hidden');

                const storageBaseUrl = "{{ asset('storage') }}";
                selectedTrackContainer.innerHTML = `
                    <div class="rounded-lg border border-gray-200 bg-gradient-to-r from-green-50 to-emerald-50 p-3 dark:border-gray-700 dark:from-gray-800/50 dark:to-gray-800/30">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="mr-3 h-10 w-10 flex-shrink-0 overflow-hidden rounded-lg bg-gray-200 dark:bg-gray-700">
                                    ${cover ? `<img src="${storageBaseUrl}/${cover}" alt="Обложка трека" class="h-full w-full object-cover">` :
                                    `<div class="flex h-full w-full items-center justify-center">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
                                                        </svg>
                                                    </div>`}
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">${title}</p>
                                    <p class="text-xs text-gray-600 dark:text-gray-400">${artist}</p>
                                </div>
                            </div>
                            <button type="button" class="edit-remove-new-track flex h-8 w-8 items-center justify-center rounded-full bg-red-100 text-red-600 hover:bg-red-200 dark:bg-red-900/30 dark:text-red-400 dark:hover:bg-red-900/50">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>
                `;

                // Удаляем контейнер поиска
                const searchContainer = editForm.querySelector('.edit-track-search').parentNode.parentNode;
                searchContainer.parentNode.removeChild(searchContainer);

                // Добавляем обработчик для кнопки удаления нового трека
                selectedTrackContainer.querySelector('.edit-remove-new-track').addEventListener('click',
                    function() {
                        selectedTrackContainer.classList.add('hidden');
                        trackIdInput.value = '';
                    });
            }

            // Обработка файлов в форме редактирования
            document.querySelectorAll('[id^="edit-comment-files-"]').forEach(input => {
                input.addEventListener('change', function() {
                    const editForm = this.closest('.comment-edit-form');
                    const filesList = editForm.querySelector('.edit-comment-files-list');

                    if (this.files.length > 0) {
                        showNewFilesList(this.files, filesList);
                    } else {
                        filesList.classList.add('hidden');
                    }
                });
            });

            // Функция для отображения новых файлов
            function showNewFilesList(files, container) {
                container.innerHTML = '';
                container.classList.remove('hidden');

                const fileListWrapper = document.createElement('div');
                fileListWrapper.className =
                    'rounded-lg border border-gray-200 bg-gradient-to-r from-green-50 to-emerald-50 p-3 dark:border-gray-700 dark:from-gray-800/50 dark:to-gray-800/30';

                const filesContainer = document.createElement('div');
                filesContainer.className = 'space-y-2';
                fileListWrapper.appendChild(filesContainer);

                const title = document.createElement('h4');
                title.className = 'mb-2 text-sm font-medium text-gray-700 dark:text-gray-300';
                title.textContent = 'Новые файлы:';
                filesContainer.appendChild(title);

                for (let i = 0; i < files.length; i++) {
                    const file = files[i];
                    const fileItem = createNewFileItem(file, i);
                    filesContainer.appendChild(fileItem);
                }

                container.appendChild(fileListWrapper);

                // Добавляем обработчики для кнопок удаления
                const removeButtons = container.querySelectorAll('.remove-new-file');
                removeButtons.forEach((button, index) => {
                    button.addEventListener('click', function() {
                        this.closest('.new-file-item').remove();

                        const remainingFiles = filesContainer.querySelectorAll('.new-file-item')
                            .length;
                        if (remainingFiles === 0) {
                            container.classList.add('hidden');
                        }
                    });
                });
            }

            // Функция для создания элемента нового файла
            function createNewFileItem(file, index) {
                const fileItem = document.createElement('div');
                fileItem.className =
                    'new-file-item flex items-center justify-between rounded-lg bg-white p-2 shadow-sm dark:bg-gray-800';

                let fileIcon = `
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500 dark:text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
            `;

                if (file.type.startsWith('audio/')) {
                    fileIcon = `
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-purple-500 dark:text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
                    </svg>
                `;
                } else if (file.type.startsWith('image/')) {
                    fileIcon = `
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-blue-500 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                `;
                }

                fileItem.innerHTML = `
                <div class="flex items-center">
                    <div class="mr-3 flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-full bg-gray-100 dark:bg-gray-700">
                        ${fileIcon}
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-700 dark:text-gray-300">${file.name}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">${(file.size / 1024).toFixed(1)} KB</p>
                    </div>
                </div>
                <button type="button" class="remove-new-file flex h-6 w-6 items-center justify-center rounded-full bg-red-100 text-red-600 hover:bg-red-200 dark:bg-red-900/30 dark:text-red-400 dark:hover:bg-red-900/50">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            `;

                return fileItem;
            }

            // Track attachment functionality for new comments
            const attachTrackBtn = document.getElementById('attach-track-btn');
            const selectedTrackContainer = document.getElementById('selected-track-container');
            const commentTrackId = document.getElementById('comment-track-id');
            let searchTimeout;

            if (attachTrackBtn) {
                attachTrackBtn.addEventListener('click', function() {
                    if (!document.getElementById('comment-track-search')) {
                        const searchContainer = document.createElement('div');
                        searchContainer.className = 'mt-2 space-y-2';
                        searchContainer.innerHTML = `
                        <div class="relative">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                            <input type="text" id="comment-track-search" class="block w-full rounded-lg border border-gray-200 bg-gray-50 p-2 pl-10 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white" placeholder="Поиск трека по названию...">
                        </div>
                        <div id="comment-track-results" class="hidden rounded-lg border border-gray-200 bg-white dark:border-gray-700 dark:bg-gray-800">
                            <div class="max-h-40 overflow-y-auto p-2">
                                <!-- Results will appear here -->
                            </div>
                        </div>
                    `;

                        selectedTrackContainer.parentNode.insertBefore(searchContainer,
                            selectedTrackContainer);

                        const trackSearch = document.getElementById('comment-track-search');
                        const trackResults = document.getElementById('comment-track-results');

                        trackSearch.focus();

                        trackSearch.addEventListener('input', function() {
                            clearTimeout(searchTimeout);

                            if (this.value.length > 2) {
                                searchTimeout = setTimeout(() => {
                                    fetch(
                                            `/theme/track/search?query=${encodeURIComponent(this.value)}`
                                        )
                                        .then(response => response.json())
                                        .then(data => {
                                            trackResults.querySelector('div')
                                                .innerHTML = '';

                                            if (data.tracks && data.tracks.length > 0) {
                                                data.tracks.forEach(track => {
                                                    const trackElement =
                                                        document.createElement(
                                                            'div');
                                                    trackElement.className =
                                                        'track-result cursor-pointer rounded-lg p-2 hover:bg-gray-100 dark:hover:bg-gray-700';
                                                    trackElement.dataset.id =
                                                        track.id;
                                                    trackElement.dataset.title =
                                                        track.title;
                                                    trackElement.dataset
                                                        .artist = track.artist;
                                                    trackElement.dataset.cover =
                                                        track.cover;

                                                    const storageBaseUrl =
                                                        "{{ asset('storage') }}";
                                                    trackElement.innerHTML = `
                                                    <div class="flex items-center">
                                                        <div class="mr-2 h-8 w-8 flex-shrink-0 overflow-hidden rounded-md bg-gray-200 dark:bg-gray-700">
                                                            <img src="${storageBaseUrl + '/' + track.cover}" alt="Обложка трека" class="h-full w-full object-cover">
                                                        </div>
                                                        <div>
                                                            <p class="text-xs font-medium text-gray-900 dark:text-white">${track.title}</p>
                                                            <p class="text-xs text-gray-500 dark:text-gray-400">${track.artist}</p>
                                                        </div>
                                                    </div>
                                                `;

                                                    trackElement
                                                        .addEventListener(
                                                            'click',
                                                            function() {
                                                                selectCommentTrack
                                                                    (this
                                                                        .dataset
                                                                        .id,
                                                                        this
                                                                        .dataset
                                                                        .title,
                                                                        this
                                                                        .dataset
                                                                        .artist,
                                                                        this
                                                                        .dataset
                                                                        .cover);
                                                            });

                                                    trackResults.querySelector(
                                                        'div').appendChild(
                                                        trackElement);
                                                });

                                                trackResults.classList.remove('hidden');
                                            } else {
                                                const noResults = document
                                                    .createElement('div');
                                                noResults.className =
                                                    'p-2 text-center text-xs text-gray-500 dark:text-gray-400';
                                                noResults.textContent =
                                                    'Треки не найдены';
                                                trackResults.querySelector('div')
                                                    .appendChild(noResults);
                                                trackResults.classList.remove('hidden');
                                            }
                                        })
                                        .catch(error => {
                                            console.error('Ошибка при поиске треков:',
                                                error);
                                        });
                                }, 300);
                            } else {
                                trackResults.classList.add('hidden');
                            }
                        });

                        document.addEventListener('click', function(event) {
                            const trackResults = document.getElementById('comment-track-results');
                            const trackSearch = document.getElementById('comment-track-search');

                            if (trackResults && trackSearch &&
                                !trackSearch.contains(event.target) &&
                                !trackResults.contains(event.target) &&
                                !event.target.closest('#attach-track-btn')) {
                                trackResults.classList.add('hidden');
                            }
                        });
                    } else {
                        document.getElementById('comment-track-search').focus();
                    }
                });
            }

            // Function to select a track for comment
            function selectCommentTrack(id, title, artist, cover) {
                document.getElementById('comment-track-id').value = id;

                const selectedTrackContainer = document.getElementById('selected-track-container');
                selectedTrackContainer.classList.remove('hidden');

                const storageBaseUrl = "{{ asset('storage') }}";
                selectedTrackContainer.innerHTML = `
                <div class="rounded-lg border border-gray-200 bg-gradient-to-r from-blue-50 to-indigo-50 p-3 shadow-sm dark:border-gray-700 dark:from-gray-800/50 dark:to-gray-800/30">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="mr-3 h-10 w-10 flex-shrink-0 overflow-hidden rounded-lg bg-gray-200 dark:bg-gray-700">
                                ${cover ? `<img src="${storageBaseUrl}/${cover}" alt="Обложка трека" class="h-full w-full object-cover">` :
                                `<div class="flex h-full w-full items-center justify-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
                                                    </svg>
                                                </div>`}
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900 dark:text-white">${title}</p>
                                <p class="text-xs text-gray-600 dark:text-gray-400">${artist}</p>
                            </div>
                        </div>
                        <button type="button" id="remove-comment-track" class="flex h-8 w-8 items-center justify-center rounded-full bg-red-100 text-red-600 hover:bg-red-200 dark:bg-red-900/30 dark:text-red-400 dark:hover:bg-red-900/50">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            `;

                const searchContainer = document.getElementById('comment-track-search').parentNode.parentNode;
                searchContainer.parentNode.removeChild(searchContainer);

                document.getElementById('remove-comment-track').addEventListener('click', function() {
                    selectedTrackContainer.classList.add('hidden');
                    document.getElementById('comment-track-id').value = '';
                });
            }

            // File attachment for new comments
            const commentFilesInput = document.getElementById('comment-files');
            const commentFilesList = document.getElementById('comment-files-list');

            if (commentFilesInput) {
                commentFilesInput.addEventListener('change', function() {
                    if (this.files.length > 0) {
                        showCommentFilesList(this.files, commentFilesList);
                    } else {
                        commentFilesList.classList.add('hidden');
                    }
                });
            }

            // Function for displaying file list for new comments
            function showCommentFilesList(files, container) {
                container.innerHTML = '';
                container.classList.remove('hidden');

                const fileListWrapper = document.createElement('div');
                fileListWrapper.className =
                    'rounded-lg border border-gray-200 bg-gradient-to-r from-blue-50 to-indigo-50 p-3 shadow-sm dark:border-gray-700 dark:from-gray-800/50 dark:to-gray-800/30';

                const filesContainer = document.createElement('div');
                // Изменяем класс для сетки вместо столбца
                filesContainer.className = 'space-y-2';
                fileListWrapper.appendChild(filesContainer);

                const title = document.createElement('h4');
                title.className = 'mb-3 text-sm font-medium text-gray-700 dark:text-gray-300';
                title.textContent = `Прикрепленные файлы (${files.length}):`;
                filesContainer.appendChild(title);

                // Создаем контейнер для файлов в сетке
                const filesGrid = document.createElement('div');
                if (files.length > 6) {
                    filesGrid.className =
                        'grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-2 max-h-48 overflow-y-auto pr-2';
                } else {
                    filesGrid.className = 'grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-2';
                }
                filesContainer.appendChild(filesGrid);

                for (let i = 0; i < files.length; i++) {
                    const file = files[i];
                    const fileItem = createCommentFileItem(file, i);
                    filesGrid.appendChild(fileItem);
                }

                container.appendChild(fileListWrapper);

                const removeButtons = container.querySelectorAll('.remove-comment-file');
                removeButtons.forEach((button, index) => {
                    button.addEventListener('click', function() {
                        this.closest('.comment-file-item').remove();

                        const remainingFiles = filesGrid.querySelectorAll('.comment-file-item')
                            .length;
                        if (remainingFiles === 0) {
                            container.classList.add('hidden');
                        } else {
                            // Обновляем счетчик файлов
                            const titleElement = container.querySelector('h4');
                            if (titleElement) {
                                titleElement.textContent =
                                    `Прикрепленные файлы (${remainingFiles}):`;
                            }
                        }
                    });
                });
            }

            // Function to create a file item for new comments
            function createCommentFileItem(file, index) {
                const fileItem = document.createElement('div');
                fileItem.className =
                    'comment-file-item flex items-center justify-between rounded-lg bg-white p-2 shadow-sm transition-all hover:shadow-md dark:bg-gray-800';

                let fileIcon = `
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500 dark:text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
        </svg>
    `;

                if (file.type.startsWith('audio/')) {
                    fileIcon = `
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-purple-500 dark:text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
            </svg>
        `;
                } else if (file.type.startsWith('image/')) {
                    fileIcon = `
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-blue-500 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
        `;
                }

                // Обрезаем длинные имена файлов
                const displayName = file.name.length > 20 ? file.name.substring(0, 17) + '...' : file.name;

                fileItem.innerHTML = `
        <div class="flex items-center min-w-0 flex-1">
            <div class="mr-2 flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-full bg-gray-100 dark:bg-gray-700">
                ${fileIcon}
            </div>
            <div class="min-w-0 flex-1">
                <p class="truncate text-sm font-medium text-gray-700 dark:text-gray-300" title="${file.name}">${displayName}</p>
                <p class="text-xs text-gray-500 dark:text-gray-400">${(file.size / 1024).toFixed(1)} KB</p>
            </div>
        </div>
        <button type="button" class="remove-comment-file ml-2 flex h-6 w-6 flex-shrink-0 items-center justify-center rounded-full bg-red-100 text-red-600 hover:bg-red-200 dark:bg-red-900/30 dark:text-red-400 dark:hover:bg-red-900/50">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    `;

                return fileItem;
            }

            // Глобальные функции для доступа из inline обработчиков
            window.selectEditTrack = selectEditTrack;
            window.showNewFilesList = showNewFilesList;
            window.createNewFileItem = createNewFileItem;
        });
    </script>
@endsection
