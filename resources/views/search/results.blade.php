@extends('layouts.app')

@section('title', 'Результаты поиска')

@section('content')
    <div class="mx-auto max-w-7xl px-4 py-8">
        <!-- Заголовок результатов -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold tracking-tight text-gray-900 dark:text-white">
                Результаты поиска
            </h1>
            @if ($query)
                <p class="mt-2 text-gray-600 dark:text-gray-400">
                    По запросу "<span class="font-medium text-gray-900 dark:text-white">{{ $query }}</span>"
                    найдено {{ $totalResults }}
                    {{ $totalResults == 1 ? 'результат' : ($totalResults < 5 ? 'результата' : 'результатов') }}
                </p>
            @endif
        </div>

        @if ($totalResults > 0)
            <div class="space-y-8">
                <!-- Пользователи -->
                @if ($users->count() > 0)
                    <div>
                        <h2 class="mb-4 text-xl font-semibold text-gray-900 dark:text-white">
                            Пользователи ({{ $users->count() }})
                        </h2>
                        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                            @foreach ($users as $user)
                                <div
                                    class="overflow-hidden rounded-xl bg-white shadow-md transition-all duration-300 hover:shadow-lg dark:bg-gray-800">
                                    <div class="p-6">
                                        <div class="flex items-center">
                                            <div class="mr-4 h-12 w-12 overflow-hidden rounded-full">
                                                @if ($user->avatar)
                                                    <img src="{{ asset('storage/avatars/' . $user->avatar) }}"
                                                        alt="Аватар" class="h-full w-full object-cover">
                                                @else
                                                    <img src="{{ asset('img/default-avatar.webp') }}" alt="Аватар"
                                                        class="h-full w-full object-cover">
                                                @endif
                                            </div>
                                            <div class="flex-1">
                                                <h3 class="font-semibold text-gray-900 dark:text-white">
                                                    <a href="{{ route('profile.index', $user->id) }}"
                                                        class="hover:text-primary-600 dark:hover:text-primary-400">
                                                        @if ($query)
                                                            {!! str_ireplace($query, '<mark class="bg-yellow-200 dark:bg-yellow-800">' . $query . '</mark>', $user->name) !!}
                                                        @else
                                                            {{ $user->name }}
                                                        @endif
                                                    </a>
                                                </h3>
                                                <div
                                                    class="mt-1 flex items-center gap-4 text-sm text-gray-500 dark:text-gray-400">
                                                    <span>{{ $user->tracks_count }} треков</span>
                                                    <span>{{ $user->followers_count }} подписчиков</span>
                                                </div>
                                            </div>
                                        </div>
                                        @if ($user->bio)
                                            <p class="mt-3 text-sm text-gray-600 dark:text-gray-400 line-clamp-2">
                                                @if ($query)
                                                    {!! str_ireplace(
                                                        $query,
                                                        '<mark class="bg-yellow-200 dark:bg-yellow-800">' . $query . '</mark>',
                                                        Str::limit($user->bio, 100),
                                                    ) !!}
                                                @else
                                                    {{ Str::limit($user->bio, 100) }}
                                                @endif
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Треки -->
                @if ($tracks->count() > 0)
                    <div>
                        <h2 class="mb-4 text-xl font-semibold text-gray-900 dark:text-white">
                            Треки ({{ $tracks->count() }})
                        </h2>
                        <div class="space-y-4">
                            @foreach ($tracks as $track)
                                <div
                                    class="overflow-hidden rounded-xl bg-white shadow-md transition-all duration-300 hover:shadow-lg dark:bg-gray-800">
                                    <div class="flex items-center p-6">
                                        <div class="mr-4 h-16 w-16 overflow-hidden rounded-lg">
                                            @if ($track->cover_image)
                                                <img src="{{ asset('storage/' . $track->cover_image) }}" alt="Обложка"
                                                    class="h-full w-full object-cover">
                                            @else
                                                <div
                                                    class="flex h-full w-full items-center justify-center bg-gray-200 dark:bg-gray-700">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="flex-1">
                                            <h3 class="font-semibold text-gray-900 dark:text-white">
                                                <a href="{{ route('tracks.show', $track->id) }}"
                                                    class="hover:text-primary-600 dark:hover:text-primary-400">
                                                    @if ($query)
                                                        {!! str_ireplace($query, '<mark class="bg-yellow-200 dark:bg-yellow-800">' . $query . '</mark>', $track->title) !!}
                                                    @else
                                                        {{ $track->title }}
                                                    @endif
                                                </a>
                                            </h3>
                                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                                от <a href="{{ route('profile.index', $track->user->id) }}"
                                                    class="hover:text-primary-600 dark:hover:text-primary-400">{{ $track->user->name }}</a>
                                            </p>
                                            <div
                                                class="mt-2 flex items-center gap-4 text-sm text-gray-500 dark:text-gray-400">
                                                <span>{{ $track->genre->name }}</span>
                                                <span class="flex items-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="mr-1 h-4 w-4"
                                                        fill="currentColor" viewBox="0 0 24 24">
                                                        <path
                                                            d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                                    </svg>
                                                    {{ $track->favorites_count }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Темы форума -->
                @if ($threads->count() > 0)
                    <div>
                        <h2 class="mb-4 text-xl font-semibold text-gray-900 dark:text-white">
                            Темы форума ({{ $threads->count() }})
                        </h2>
                        <div class="space-y-4">
                            @foreach ($threads as $thread)
                                <div
                                    class="overflow-hidden rounded-xl bg-white shadow-md transition-all duration-300 hover:shadow-lg dark:bg-gray-800">
                                    <div class="p-6">
                                        <div class="flex items-start justify-between">
                                            <div class="flex-1">
                                                <h3 class="font-semibold text-gray-900 dark:text-white">
                                                    <a href="{{ route('thread.show', $thread->id) }}"
                                                        class="hover:text-primary-600 dark:hover:text-primary-400">
                                                        @if ($query)
                                                            {!! str_ireplace($query, '<mark class="bg-yellow-200 dark:bg-yellow-800">' . $query . '</mark>', $thread->title) !!}
                                                        @else
                                                            {{ $thread->title }}
                                                        @endif
                                                    </a>
                                                </h3>
                                                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                                    от <a href="{{ route('profile.index', $thread->user->id) }}"
                                                        class="hover:text-primary-600 dark:hover:text-primary-400">{{ $thread->user->name }}</a>
                                                    в категории <span
                                                        class="font-medium">{{ $thread->category->name }}</span>
                                                </p>
                                                @if ($thread->content)
                                                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-400 line-clamp-2">
                                                        @if ($query)
                                                            {!! str_ireplace(
                                                                $query,
                                                                '<mark class="bg-yellow-200 dark:bg-yellow-800">' . $query . '</mark>',
                                                                Str::limit(strip_tags($thread->content), 150),
                                                            ) !!}
                                                        @else
                                                            {{ Str::limit(strip_tags($thread->content), 150) }}
                                                        @endif
                                                    </p>
                                                @endif
                                                <div
                                                    class="mt-3 flex items-center gap-4 text-sm text-gray-500 dark:text-gray-400">
                                                    <span class="flex items-center">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="mr-1 h-4 w-4"
                                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                                                        </svg>
                                                        {{ $thread->comments_count }} комментариев
                                                    </span>
                                                    <span>{{ $thread->created_at->diffForHumans() }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        @else
            <!-- Пустое состояние -->
            <div class="py-12 text-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12 text-gray-400" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-white">
                    @if ($query)
                        Ничего не найдено
                    @else
                        Введите поисковый запрос
                    @endif
                </h3>
                <p class="mt-2 text-gray-500 dark:text-gray-400">
                    @if ($query)
                        Попробуйте изменить поисковый запрос или использовать другие ключевые слова
                    @else
                        Начните вводить, чтобы найти пользователей, треки или темы форума
                    @endif
                </p>
            </div>
        @endif
    </div>
@endsection
