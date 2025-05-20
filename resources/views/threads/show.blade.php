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
                                class="ml-1 text-sm font-medium text-gray-700 hover:text-primary-600 dark:text-gray-400 dark:hover:text-white md:ml-2">
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
                                {{ $thread->created_at->diffForHumans() }}
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
                                    @if (Auth::id() === $thread->user_id || (Auth::check() && Auth::user()->hasRole('admin')))
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
                                    <a href="#"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700">
                                        <div class="flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 h-4 w-4" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                                            </svg>
                                            Сохранить
                                        </div>
                                    </a>
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
                {{-- <div class="mt-6 flex items-center justify-between border-t border-gray-200 pt-6 dark:border-gray-700">
                    <div class="flex items-center gap-4">
                        <button
                            class="flex items-center text-gray-500 hover:text-primary-600 dark:text-gray-400 dark:hover:text-primary-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="mr-1.5 h-5 w-5" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5" />
                            </svg>
                            <span class="text-sm font-medium">42</span>
                        </button>
                        <button
                            class="flex items-center text-gray-500 hover:text-primary-600 dark:text-gray-400 dark:hover:text-primary-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="mr-1.5 h-5 w-5" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 14H5.236a2 2 0 01-1.789-2.894l3.5-7A2 2 0 018.736 3h4.018a2 2 0 01.485.06l3.76.94m-7 10v5a2 2 0 002 2h.095c.5 0 .905-.405.905-.905 0-.714.211-1.412.608-2.006L17 13V4m-7 10h2" />
                            </svg>
                            <span class="text-sm font-medium">3</span>
                        </button>
                        <button
                            class="flex items-center text-gray-500 hover:text-primary-600 dark:text-gray-400 dark:hover:text-primary-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="mr-1.5 h-5 w-5" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
                            </svg>
                            <span class="text-sm font-medium">Поделиться</span>
                        </button>
                    </div>
                    <button
                        class="flex items-center text-gray-500 hover:text-primary-600 dark:text-gray-400 dark:hover:text-primary-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="mr-1.5 h-5 w-5" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                        </svg>
                        <span class="text-sm font-medium">Сохранить</span>
                    </button>
                </div> --}}
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
                    <div
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
                                        {{ $comment->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-1">
                                <button
                                    class="rounded-full p-1 text-gray-500 hover:bg-gray-100 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Прикрепленный трек в комментарии -->
                        @if ($comment->track)
                            <div
                                class="mb-3 rounded-lg border border-gray-200 bg-gray-50/50 p-2 dark:border-gray-700 dark:bg-gray-700/50">
                                <div class="flex items-center">
                                    <div class="mr-2 flex-shrink-0">
                                        <div
                                            class="relative h-10 w-10 overflow-hidden rounded-md bg-gray-200 dark:bg-gray-600">
                                            @if ($comment->track->cover_image)
                                                <img src="{{ asset('storage/' . $comment->track->cover_image) }}"
                                                    alt="Обложка трека" class="h-full w-full object-cover">
                                            @else
                                                <div
                                                    class="flex h-full w-full items-center justify-center bg-gray-300 dark:bg-gray-600">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
                                                    </svg>
                                                </div>
                                            @endif
                                            <button data-track-id="{{ $comment->track->id }}"
                                                class="play-button absolute inset-0 flex items-center justify-center bg-black bg-opacity-50 opacity-0 transition-opacity hover:opacity-100">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h4 class="truncate text-xs font-medium text-gray-900 dark:text-white">
                                            {{ $comment->track->title }}</h4>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">
                                            {{ $comment->track->user->name }}</p>
                                        <div class="mt-1 flex items-center">
                                            <button data-track-id="{{ $comment->track->id }}"
                                                class="play-button mr-1 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                                </svg>
                                            </button>
                                            <div class="w-24 rounded-full bg-gray-200 dark:bg-gray-600">
                                                <div
                                                    class="h-1 w-0 rounded-full bg-primary-600 dark:bg-primary-500 progress-bar">
                                                </div>
                                            </div>
                                            <span
                                                class="ml-1 text-xs text-gray-500 dark:text-gray-400 track-time">0:00</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="prose prose-sm max-w-none dark:prose-invert">
                            {!! $comment->content !!}
                        </div>

                        <!-- Прикрепленные файлы в комментарии (улучшенный вид) -->
                        @if ($comment->files && $comment->files->count() > 0)
                            <div
                                class="mt-3 flex flex-wrap gap-2 rounded border border-gray-200 bg-gray-50/50 p-2 dark:border-gray-700 dark:bg-gray-700/50">
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

                                    <a href="{{ asset('storage/' . $file->path) }}"
                                        download="{{ $file->original_name }}"
                                        class="flex items-center rounded-full {{ $bgColor }} px-3 py-1 text-xs font-medium {{ $iconColor }} transition-all hover:shadow-sm dark:bg-opacity-20 dark:text-opacity-90">
                                        @if ($icon == 'music')
                                            <svg xmlns="http://www.w3.org/2000/svg" class="mr-1 h-3 w-3" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
                                            </svg>
                                        @elseif ($icon == 'image')
                                            <svg xmlns="http://www.w3.org/2000/svg" class="mr-1 h-3 w-3" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        @elseif ($icon == 'archive')
                                            <svg xmlns="http://www.w3.org/2000/svg" class="mr-1 h-3 w-3" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                                            </svg>
                                        @elseif ($icon == 'pdf')
                                            <svg xmlns="http://www.w3.org/2000/svg" class="mr-1 h-3 w-3" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                            </svg>
                                        @else
                                            <svg xmlns="http://www.w3.org/2000/svg" class="mr-1 h-3 w-3" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                        @endif
                                        {{ Str::limit($file->original_name, 15) }}
                                    </a>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endforeach

                <!-- Форма добавления комментария (улучшенная) -->
                <div class="sticky bottom-0 rounded-lg bg-white p-4 shadow-lg dark:bg-gray-800/90 dark:backdrop-blur-sm">
                    <form action="{{ route('comments.store') }}" method="POST" enctype="multipart/form-data"
                        class="space-y-2">
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

                        <div class="flex items-center gap-2">
                            <!-- Прикрепить трек к комментарию -->
                            <button type="button" id="attach-track-btn"
                                class="flex items-center rounded-lg border border-gray-300 bg-white px-2 py-1 text-xs font-medium text-gray-700 shadow-sm transition-all hover:bg-gray-50 hover:shadow dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:hover:bg-gray-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="mr-1 h-3.5 w-3.5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
                                </svg>
                                Трек
                            </button>
                            <input type="hidden" name="track_id" id="comment-track-id">
                            <div id="selected-track-container" class="hidden"></div>

                            <!-- Прикрепить файлы к комментарию -->
                            <label for="comment-files"
                                class="flex items-center rounded-lg border border-gray-300 bg-white px-2 py-1 text-xs font-medium text-gray-700 shadow-sm transition-all hover:bg-gray-50 hover:shadow dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:hover:bg-gray-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="mr-1 h-3.5 w-3.5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                                </svg>
                                Файл
                            </label>
                            <input type="file" id="comment-files" name="files[]" multiple class="hidden">
                            <div id="comment-files-list" class="hidden"></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Add this to your format-time.blade.php file, replacing the current track attachment functionality -->

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Track attachment functionality for comments
            const attachTrackBtn = document.getElementById('attach-track-btn');
            const selectedTrackContainer = document.getElementById('selected-track-container');
            const commentTrackId = document.getElementById('comment-track-id');
            let searchTimeout;

            if (attachTrackBtn) {
                attachTrackBtn.addEventListener('click', function() {
                    // Create and show the search input and results container
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

                        // Focus the search input
                        trackSearch.focus();

                        // Add event listener for search input
                        trackSearch.addEventListener('input', function() {
                            clearTimeout(searchTimeout);

                            if (this.value.length > 2) {
                                // Add delay to prevent too many requests
                                searchTimeout = setTimeout(() => {
                                    fetch(
                                            `/theme/track/search?query=${encodeURIComponent(this.value)}`
                                        )
                                        .then(response => response.json())
                                        .then(data => {
                                            // Clear current results
                                            trackResults.querySelector('div')
                                                .innerHTML = '';

                                            if (data.tracks && data.tracks.length > 0) {
                                                // Add new results
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

                                                    // Add click handler
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
                                                // Show message if no tracks found
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

                        // Close results when clicking outside
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
                        // If search is already visible, just focus it
                        document.getElementById('comment-track-search').focus();
                    }
                });
            }

            // Function to select a track for comment
            function selectCommentTrack(id, title, artist, cover) {
                // Update hidden input with track ID
                document.getElementById('comment-track-id').value = id;

                // Update selected track display
                const selectedTrackContainer = document.getElementById('selected-track-container');
                selectedTrackContainer.classList.remove('hidden');

                const storageBaseUrl = "{{ asset('storage') }}";
                selectedTrackContainer.innerHTML = `
                <div class="mt-2 rounded-lg border border-gray-200 bg-gray-50 p-2 dark:border-gray-700 dark:bg-gray-800">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="mr-2 h-8 w-8 flex-shrink-0 overflow-hidden rounded bg-gray-200 dark:bg-gray-700">
                                ${cover ? `<img src="${storageBaseUrl}/${cover}" alt="Обложка трека" class="h-full w-full object-cover">` :
                                `<div class="flex h-full w-full items-center justify-center">
                                                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
                                                                                    </svg>
                                                                                </div>`}
                            </div>
                            <div>
                                <p class="text-xs font-medium text-gray-900 dark:text-white">${title}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">${artist}</p>
                            </div>
                        </div>
                        <button type="button" id="remove-comment-track" class="flex h-6 w-6 items-center justify-center rounded-full text-gray-500 hover:bg-gray-100 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            `;

                // Remove search container
                const searchContainer = document.getElementById('comment-track-search').parentNode.parentNode;
                searchContainer.parentNode.removeChild(searchContainer);

                // Add event listener to remove button
                document.getElementById('remove-comment-track').addEventListener('click', function() {
                    selectedTrackContainer.classList.add('hidden');
                    document.getElementById('comment-track-id').value = '';
                });
            }

            // Fix for file attachment list to prevent form from becoming too large
            const commentFilesInput = document.getElementById('comment-files');
            const commentFilesList = document.getElementById('comment-files-list');

            if (commentFilesInput) {
                commentFilesInput.addEventListener('change', function() {
                    if (this.files.length > 0) {
                        showFilesList(this.files, commentFilesList);
                    } else {
                        commentFilesList.classList.add('hidden');
                    }
                });
            }

            // Improved function for displaying file list with fixed height
            function showFilesList(files, container) {
                container.innerHTML = '';
                container.classList.remove('hidden');

                const fileListWrapper = document.createElement('div');
                fileListWrapper.className =
                    'mt-2 rounded-lg border border-gray-200 bg-gray-50 dark:border-gray-700 dark:bg-gray-800';

                // Add a max-height with scrolling to prevent the form from becoming too large
                if (files.length > 3) {
                    fileListWrapper.classList.add('max-h-32', 'overflow-y-auto');
                }

                // Create a container for the files
                const filesContainer = document.createElement('div');
                filesContainer.className = 'p-2 space-y-2';
                fileListWrapper.appendChild(filesContainer);

                for (let i = 0; i < files.length; i++) {
                    const file = files[i];
                    const fileItem = createFileItem(file, i);
                    filesContainer.appendChild(fileItem);
                }

                container.appendChild(fileListWrapper);

                // Add a counter if there are many files
                if (files.length > 3) {
                    const fileCounter = document.createElement('div');
                    fileCounter.className = 'text-xs text-gray-500 mt-1 text-right dark:text-gray-400';
                    fileCounter.textContent = `Прикреплено файлов: ${files.length}`;
                    container.appendChild(fileCounter);
                }

                // Add event listeners to remove buttons
                const removeButtons = container.querySelectorAll('.remove-file');
                removeButtons.forEach((button, index) => {
                    button.addEventListener('click', function() {
                        this.closest('.file-item').remove();

                        // Update the counter
                        const remainingFiles = filesContainer.querySelectorAll('.file-item').length;
                        if (remainingFiles === 0) {
                            container.classList.add('hidden');
                        } else if (files.length > 3) {
                            const counter = container.querySelector('.text-right');
                            if (counter) {
                                counter.textContent = `Прикреплено файлов: ${remainingFiles}`;
                            }
                        }
                    });
                });
            }

            // Function to create a file item (compact version)
            function createFileItem(file, index) {
                const fileItem = document.createElement('div');
                fileItem.className =
                    'file-item flex items-center justify-between rounded-lg bg-white p-1.5 shadow-sm dark:bg-gray-700';

                // Determine icon based on file type
                let fileIcon = `
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-gray-500 dark:text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
            `;

                if (file.type.startsWith('audio/')) {
                    fileIcon = `
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-purple-500 dark:text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
                    </svg>
                `;
                } else if (file.type.startsWith('image/')) {
                    fileIcon = `
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-blue-500 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                `;
                }

                // Create a more compact file item
                fileItem.innerHTML = `
                <div class="flex items-center overflow-hidden">
                    <span class="mr-1.5 flex-shrink-0">${fileIcon}</span>
                    <span class="truncate text-xs font-medium text-gray-700 dark:text-gray-300">${file.name}</span>
                    <span class="ml-1.5 flex-shrink-0 text-xs text-gray-500 dark:text-gray-400">(${(file.size / 1024).toFixed(1)} KB)</span>
                </div>
                <button type="button" class="remove-file ml-1 flex h-5 w-5 flex-shrink-0 items-center justify-center rounded-full text-gray-500 hover:bg-gray-100 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            `;

                return fileItem;
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            // Обработка удаления темы с подтверждением
            const deleteButtons = document.querySelectorAll('.delete-thread-btn');
            deleteButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();

                    if (confirm(
                            'Вы уверены, что хотите удалить эту тему? Это действие нельзя отменить.'
                        )) {
                        this.closest('form').submit();
                    }
                });
            });
        });
    </script>
@endsection
