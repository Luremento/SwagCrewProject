@extends('layouts.app')

@php
    function pluralRussian($count, $one, $few, $many)
    {
        $mod10 = $count % 10;
        $mod100 = $count % 100;
        if ($mod10 == 1 && $mod100 != 11) {
            return $one;
        } elseif ($mod10 >= 2 && $mod10 <= 4 && ($mod100 < 10 || $mod100 >= 20)) {
            return $few;
        } else {
            return $many;
        }
    }

    $followersCount = $user->followers->count();
    $followersLabel = pluralRussian($followersCount, 'подписчик', 'подписчика', 'подписчиков');

    $followingCount = $user->following->count();
    $followingLabel = pluralRussian($followingCount, 'подписка', 'подписки', 'подписок');

    $tracksCount = $user->tracks->count();
    $tracksLabel = pluralRussian($tracksCount, 'трек', 'трека', 'треков');

    $threadsCount = $user->threads->count();
    $threadsLabel = pluralRussian($threadsCount, 'тема', 'темы', 'тем');
@endphp

@section('title', 'Профиль пользователя')

@section('content')
    <!-- Шапка профиля -->
    <div class="overflow-hidden rounded-3xl bg-white shadow-xl dark:bg-gray-800/80 dark:backdrop-blur-sm">
        <div class="relative">
            <!-- Фон профиля -->
            <div
                class="h-64 bg-gradient-to-r from-primary-600 via-primary-700 to-purple-800 dark:from-primary-800 dark:via-primary-900 dark:to-purple-900">
                <div class="absolute inset-0 opacity-10">
                    <svg class="h-full w-full" viewBox="0 0 100 100" preserveAspectRatio="none">
                        <defs>
                            <pattern id="profile-pattern" patternUnits="userSpaceOnUse" width="100" height="100"
                                patternTransform="rotate(45)">
                                <path d="M25,0 L25,100 M50,0 L50,100 M75,0 L75,100" stroke="currentColor"
                                    stroke-width="1" />
                                <circle cx="25" cy="25" r="1" fill stroke-width="1" />
                                <circle cx="25" cy="25" r="1" fill="currentColor" />
                                <circle cx="75" cy="75" r="1" fill="currentColor" />
                            </pattern>
                        </defs>
                        <rect width="100%" height="100%" fill="url(#profile-pattern)" />
                    </svg>
                </div>
            </div>

            <!-- Аватар и основная информация -->
            <div class="absolute bottom-0 left-0 transform translate-y-1/2 px-8">
                <div class="relative">
                    <div
                        class="relative h-36 w-36 overflow-hidden rounded-full border-4 border-white shadow-xl dark:border-gray-800">
                        @if ($user->avatar)
                            <img src="{{ asset('storage/avatars/' . $user->avatar) }}" alt="Аватар"
                                class="h-full w-full object-cover">
                        @else
                            <img src="{{ asset('img/default-avatar.webp') }}" alt="Аватар"
                                class="h-full w-full object-cover">
                        @endif
                    </div>
                    @auth
                        @if (auth()->id() === $user->id)
                            <form action="{{ route('profile.avatar.upload') }}" method="POST" enctype="multipart/form-data"
                                id="avatar-upload-form">
                                @csrf
                                <input type="file" name="avatar" id="avatar-input" class="hidden" accept="image/*"
                                    onchange="document.getElementById('avatar-upload-form').submit();">
                                <label for="avatar-input"
                                    class="absolute bottom-3 right-3 flex h-10 w-10 cursor-pointer items-center justify-center rounded-full bg-primary-600 text-white shadow-lg transition-all duration-200 hover:bg-primary-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </label>
                            </form>
                        @endif
                    @endauth
                </div>
            </div>

            <!-- Информация о пользователе -->
            {{-- <div class="ml-48 pb-6 pt-8">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $user->name }}</h1>
                <div class="mt-1 flex items-center">
                    <span
                        class="inline-flex items-center rounded-full bg-primary-600/90 px-3 py-1 text-sm font-medium text-white backdrop-blur-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="mr-1 h-4 w-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Проверенный музыкант
                    </span>
                </div>
            </div> --}}

            <!-- Кнопки действий -->
            @auth
                <div class="absolute bottom-0 right-0 transform translate-y-1/2 px-8">
                    @if (auth()->id() === $user->id)
                        <a href="{{ route('profile.edit') }}"
                            class="group relative inline-flex overflow-hidden rounded-full bg-primary-600 px-6 py-3 font-medium text-white shadow-lg transition-all duration-300 hover:bg-primary-700">
                            <span class="relative z-10 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                </svg>
                                Редактировать профиль
                            </span>
                        </a>
                    @else
                        <div class="flex space-x-3">
                            @if (Auth::user()->following->contains($user->id))
                                <form action="{{ route('unfollow', $user) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="rounded-full bg-gray-300 px-6 py-3 font-medium text-gray-800 hover:bg-gray-400 dark:bg-gray-600 dark:text-white dark:hover:bg-gray-500">
                                        Отписаться
                                    </button>
                                </form>
                            @else
                                <form action="{{ route('follow', $user) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="rounded-full bg-primary-600 px-6 py-3 font-medium text-white hover:bg-primary-700">
                                        Подписаться
                                    </button>
                                </form>
                            @endif
                        </div>
                    @endif
                </div>
            @endauth
        </div>

        <!-- Статистика профиля -->
        <div class="mt-20 grid grid-cols-2 gap-4 px-8 py-6 sm:grid-cols-3 md:grid-cols-4">
            <div
                class="flex flex-col items-center rounded-xl bg-gray-50 p-4 transition-all duration-300 hover:bg-gray-100 dark:bg-gray-700/50 dark:hover:bg-gray-700">
                <div class="text-3xl font-bold text-primary-600 dark:text-primary-400">
                    {{ $tracksCount }}
                </div>
                <div class="text-sm font-medium text-gray-600 dark:text-gray-400">
                    {{ $tracksLabel }}
                </div>
            </div>
            <div
                class="flex flex-col items-center rounded-xl bg-gray-50 p-4 transition-all duration-300 hover:bg-gray-100 dark:bg-gray-700/50 dark:hover:bg-gray-700">
                <div class="text-3xl font-bold text-primary-600 dark:text-primary-400">{{ $followersCount }}</div>
                <div class="text-sm font-medium text-gray-600 dark:text-gray-400">{{ $followersLabel }}</div>
            </div>
            <div
                class="flex flex-col items-center rounded-xl bg-gray-50 p-4 transition-all duration-300 hover:bg-gray-100 dark:bg-gray-700/50 dark:hover:bg-gray-700">
                <div class="text-3xl font-bold text-primary-600 dark:text-primary-400">{{ $followingCount }}</div>
                <div class="text-sm font-medium text-gray-600 dark:text-gray-400">{{ $followingLabel }}</div>
            </div>
            <div
                class="flex flex-col items-center rounded-xl bg-gray-50 p-4 transition-all duration-300 hover:bg-gray-100 dark:bg-gray-700/50 dark:hover:bg-gray-700">
                <div class="text-3xl font-bold text-primary-600 dark:text-primary-400">
                    {{ $threadsCount }}
                </div>
                <div class="text-sm font-medium text-gray-600 dark:text-gray-400">
                    {{ $threadsLabel }} на форуме
                </div>
            </div>
        </div>

        <!-- Информация о пользователе -->
        <div class="border-t border-gray-200 px-8 py-8 dark:border-gray-700">
            @if ($user->bio)
                <h2 class="mb-6 text-2xl font-bold text-gray-900 dark:text-white">О себе</h2>
                <p class="mb-8 text-lg leading-relaxed text-gray-600 dark:text-gray-400">
                    {{ $user->bio }}
                </p>
            @endif

            <div class="grid grid-cols-1 gap-8 md:grid-cols-2">
                <!-- Контакты -->
                <div class="rounded-xl bg-gray-50 p-6 dark:bg-gray-700/30">
                    <h3 class="mb-4 text-xl font-semibold text-gray-900 dark:text-white">Контакты</h3>
                    <ul class="space-y-3">
                        @php
                            $publicContacts = $user->contacts->where('is_public', true);
                        @endphp

                        @if ($publicContacts->isEmpty())
                            <li class="text-gray-500 dark:text-gray-400">Пользователь не указал контактную информацию</li>
                        @else
                            @foreach ($publicContacts as $contact)
                                <li class="flex items-center text-gray-600 dark:text-gray-400">
                                    <div
                                        class="mr-3 flex h-10 w-10 items-center justify-center rounded-full bg-primary-100 text-primary-600 dark:bg-primary-900/50 dark:text-primary-400">
                                        @if ($contact->type == 'email')
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                            </svg>
                                        @elseif($contact->type == 'website')
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        @elseif($contact->type == 'phone')
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                            </svg>
                                        @endif
                                    </div>
                                    @if ($contact->type == 'email')
                                        <a href="mailto:{{ $contact->value }}"
                                            class="text-lg hover:text-primary-600 dark:hover:text-primary-400">{{ $contact->value }}</a>
                                    @elseif($contact->type == 'website')
                                        <a href="{{ $contact->value }}" target="_blank" rel="noopener noreferrer"
                                            class="text-lg hover:text-primary-600 dark:hover:text-primary-400">{{ $contact->value }}</a>
                                    @else
                                        <span class="text-lg">{{ $contact->value }}</span>
                                    @endif
                                </li>
                            @endforeach
                        @endif
                    </ul>
                </div>

                <!-- Социальные сети -->
                <div class="rounded-xl bg-gray-50 p-6 dark:bg-gray-700/30">
                    <h3 class="mb-4 text-xl font-semibold text-gray-900 dark:text-white">Социальные сети</h3>
                    @if ($user->socialLinks->isEmpty())
                        <p class="text-gray-500 dark:text-gray-400">Пользователь не указал социальные сети</p>
                    @else
                        <div class="flex flex-wrap gap-4">
                            @foreach ($user->socialLinks as $socialLink)
                                @php
                                    $fullUrl = '';
                                    $icon = '';

                                    if ($socialLink->platform == 'vk') {
                                        $fullUrl = 'https://vk.com/' . $socialLink->url;
                                        $icon = '<svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                                    <path d="M15.684 0H8.316C1.592 0 0 1.592 0 8.316v7.368C0 22.408 1.592 24 8.316 24h7.368C22.408 24 24 22.408 24 15.684V8.316C24 1.592 22.408 0 15.684 0zm3.692 16.711h-1.962c-.77 0-.952-.613-2.263-1.926-1.138-1.116-1.615-1.275-1.894-1.275-.386 0-.481.11-.481.628v1.764c0 .449-.245.809-1.111.809-1.699 0-3.586-1.03-4.913-2.928-1.989-2.726-2.528-4.791-2.528-5.225 0-.285.11-.55.628-.55h1.96c.47 0 .64.285.826.952.91 2.726 2.437 5.109 3.062 5.109.236 0 .346-.11.346-.706V10.62c-.08-1.267-.728-1.37-.728-1.82 0-.218.182-.436.47-.436h3.084c.41 0 .56.218.56.687v3.667c0 .41.182.55.3.55.235 0 .436-.14.873-.578 1.35-1.518 2.323-3.85 2.323-3.85.127-.285.323-.55.814-.55h1.961c.59 0 .716.307.59.726-.245 1.138-2.625 4.49-2.625 4.49-.207.345-.285.496 0 .883.207.307.896.883 1.35 1.422.896 1.03 1.577 1.895 1.765 2.491.207.591-.11.887-.7.887z"/>
                                                </svg>';
                                    } elseif ($socialLink->platform == 'tiktok') {
                                        $fullUrl = 'https://tiktok.com/@' . $socialLink->url;
                                        $icon = '<svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                                    <path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z"/>
                                                </svg>';
                                    } elseif ($socialLink->platform == 'telegram') {
                                        $fullUrl = 'https://t.me/' . $socialLink->url;
                                        $icon = '<svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                                    <path d="M11.944 0A12 12 0 0 0 0 12a12 12 0 0 0 12 12 12 12 0 0 0 12-12A12 12 0 0 0 12 0a12 12 0 0 0-.056 0zm4.962 7.224c.1-.002.321.023.465.14a.506.506 0 0 1 .171.325c.016.093.036.306.02.472-.18 1.898-.962 6.502-1.36 8.627-.168.9-.499 1.201-.82 1.23-.696.065-1.225-.46-1.9-.902-1.056-.693-1.653-1.124-2.678-1.8-1.185-.78-.417-1.21.258-1.91.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345-.48.33-.913.49-1.302.48-.428-.008-1.252-.241-1.865-.44-.752-.245-1.349-.374-1.297-.789.027-.216.325-.437.893-.663 3.498-1.524 5.83-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635z"/>
                                                </svg>';
                                    }
                                @endphp

                                <a href="{{ $fullUrl }}" target="_blank" rel="noopener noreferrer"
                                    class="flex h-12 w-12 items-center justify-center rounded-full bg-white text-gray-600 shadow-md transition-all duration-200 hover:-translate-y-1 hover:bg-primary-50 hover:text-primary-600 hover:shadow-lg dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-primary-400">
                                    {!! $icon !!}
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Вкладки профиля -->
    <div class="mt-10">
        <!-- Содержимое вкладки "Треки" -->
        <!-- Треки пользователя -->
        <div class="mt-8">
            <div class="mb-8 flex flex-wrap items-center justify-between gap-4">
                <h2 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                    <span class="relative">
                        Треки пользователя
                        <span class="absolute -bottom-1 left-0 h-1 w-1/2 rounded bg-primary-500"></span>
                    </span>
                </h2>
                @if ($user->tracks->count() > 0)
                    <div class="flex items-center">
                        <span class="mr-3 text-gray-600 dark:text-gray-400">Сортировать:</span>
                        <select id="trackSortSelect"
                            class="rounded-full border-none bg-gray-100 px-4 py-2 text-gray-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 dark:bg-gray-700 dark:text-gray-300">
                            <option value="newest">Новые</option>
                            <option value="popular">Популярные</option>
                            <option value="oldest">Старые</option>
                            <option value="alphabetical">По алфавиту</option>
                        </select>
                    </div>
                @endif
            </div>

            @if ($user->tracks->count() > 0)
                <div id="tracksContainer" class="space-y-6">
                    @foreach ($user->tracks as $track)
                        <div data-track-id="{{ $track->id }}" data-created="{{ $track->created_at->timestamp }}"
                            data-favorites="{{ $track->favorites_count ?? 0 }}"
                            data-title="{{ strtolower($track->title) }}"
                            class="track-item group overflow-hidden rounded-2xl bg-white shadow-lg transition-all duration-300 hover:shadow-xl dark:bg-gray-800/80 dark:backdrop-blur-sm">
                            <div class="flex flex-col p-6 sm:flex-row sm:items-center">
                                <div
                                    class="relative mb-6 aspect-square w-full overflow-hidden rounded-xl sm:mb-0 sm:mr-6 sm:w-48">
                                    <img src="{{ asset('storage/' . $track->cover_image) }}" alt="Обложка трека"
                                        class="h-full w-full object-cover transition-transform duration-700 group-hover:scale-110">
                                    <div
                                        class="absolute inset-0 flex items-center justify-center bg-black/40 opacity-0 transition-opacity duration-300 group-hover:opacity-100">
                                        <button
                                            class="flex h-16 w-16 items-center justify-center rounded-full bg-primary-600/90 text-white shadow-lg backdrop-blur-sm transition-all duration-300 hover:scale-110 hover:bg-primary-600">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                            </svg>
                                        </button>
                                    </div>

                                    <!-- Индикатор количества лайков -->
                                    @if ($track->favorites_count > 0)
                                        <div
                                            class="absolute top-3 right-3 flex items-center rounded-full bg-red-500/90 px-2 py-1 text-xs font-medium text-white backdrop-blur-sm">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="mr-1 h-3 w-3"
                                                fill="currentColor" viewBox="0 0 24 24">
                                                <path
                                                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                            </svg>
                                            {{ $track->favorites_count }}
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-1">
                                    <div class="mb-4 flex flex-wrap items-start justify-between gap-2">
                                        <div>
                                            <h3 class="text-2xl font-bold text-gray-900 dark:text-white">
                                                {{ $track->title }}
                                            </h3>
                                        </div>
                                    </div>
                                    <div class="mb-4 flex flex-wrap gap-2">
                                        <span
                                            class="rounded-full bg-gray-100 px-3 py-1 text-sm font-medium text-gray-700 dark:bg-gray-700 dark:text-gray-300">{{ $track->genre->name }}</span>
                                    </div>
                                    <a href="{{ route('profile.index', $track->user->id) }}"
                                        class="mb-6 text-gray-600 line-clamp-2 dark:text-gray-400">
                                        {{ $track->user->name }}
                                    </a>
                                    <div class="flex flex-wrap items-center justify-between gap-4">
                                        <div class="flex items-center gap-4">
                                            <div class="flex items-center text-red-500 dark:text-red-400">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="mr-1.5 h-5 w-5"
                                                    fill="currentColor" viewBox="0 0 24 24">
                                                    <path
                                                        d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                                </svg>
                                                <span
                                                    class="text-sm font-medium">{{ $track->favorites_count ?? 0 }}</span>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-3">
                                            <span class="text-sm text-gray-500 dark:text-gray-400">Опубликовано:
                                                {{ $track->created_at->format('d.m.Y') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="rounded-2xl bg-gray-50 p-12 text-center dark:bg-gray-800/50">
                    <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-16 w-16 text-gray-400" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
                    </svg>
                    <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-white">
                        @if (auth()->check() && auth()->id() === $user->id)
                            У вас пока нет треков
                        @else
                            У пользователя пока нет треков
                        @endif
                    </h3>
                    <p class="mt-2 text-gray-500 dark:text-gray-400">
                        @if (auth()->check() && auth()->id() === $user->id)
                            Загрузите свой первый трек и поделитесь музыкой с миром!
                        @else
                            Пользователь еще не загружал музыку
                        @endif
                    </p>
                    @if (auth()->check() && auth()->id() === $user->id)
                        <a href="{{ route('track.create') }}"
                            class="mt-4 inline-flex items-center rounded-full bg-primary-600 px-4 py-2 text-sm font-medium text-white hover:bg-primary-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 h-4 w-4" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4v16m8-8H4" />
                            </svg>
                            Загрузить трек
                        </a>
                    @endif
                </div>
            @endif
        </div>

        <!-- Темы на форуме -->
        <div class="mt-16 mb-8">
            <h2 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white mb-8">
                <span class="relative">
                    Темы на форуме
                    <span class="absolute -bottom-1 left-0 h-1 w-1/2 rounded bg-primary-500"></span>
                </span>
            </h2>

            @if ($topTopics->count() > 0)
                <div class="space-y-4">
                    @foreach ($topTopics as $item)
                        <div
                            class="group overflow-hidden rounded-2xl bg-white shadow-lg transition-all duration-300 hover:-translate-y-1 hover:shadow-xl dark:bg-gray-800/80 dark:backdrop-blur-sm">
                            <div class="p-6">
                                <div class="mb-4 flex items-center justify-between">
                                    <div class="flex items-center">
                                        @if ($item->user->avatar)
                                            <img src="{{ asset('storage/avatars/' . $item->user->avatar) }}"
                                                alt="Аватар" class="mr-3 h-10 w-10 rounded-full">
                                        @else
                                            <img src="{{ asset('img/default-avatar.webp') }}" alt="Аватар"
                                                class="mr-3 h-10 w-10 rounded-full">
                                        @endif
                                        <div>
                                            <a href="{{ route('profile.index', $item->user->id) }}"
                                                class="font-medium text-gray-900 hover:text-primary-600 dark:text-white dark:hover:text-primary-400">{{ $item->user->name }}</a>
                                        </div>
                                    </div>
                                    <div
                                        class="flex items-center rounded-full bg-primary-50 px-3 py-1 text-primary-600 dark:bg-primary-900/30 dark:text-primary-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="mr-1 h-4 w-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                                        </svg>
                                        <span class="text-sm font-medium">{{ $item->category->name }}</span>
                                    </div>
                                </div>
                                <h3 class="mb-2 text-xl font-bold text-gray-900 dark:text-white">
                                    <a href="{{ route('thread.show', $item->id) }}"
                                        class="hover:text-primary-600 dark:hover:text-primary-400">{{ $item->title }}</a>
                                </h3>
                                <p class="mb-4 text-gray-600 line-clamp-2 dark:text-gray-400">
                                    {{ $item->content }}
                                </p>
                                <div class="flex flex-wrap gap-2">
                                    @foreach ($item->tags as $tag)
                                        <span
                                            class="rounded-full bg-gray-100 px-3 py-1 text-xs font-medium text-gray-700 dark:bg-gray-700 dark:text-gray-300">{{ $tag->name }}</span>
                                    @endforeach
                                </div>
                                <div class="mt-6 flex items-center justify-between">
                                    <div class="flex items-center gap-4">
                                        <div class="flex items-center text-gray-500 dark:text-gray-400">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="mr-1.5 h-5 w-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                                            </svg>
                                            <span class="text-sm font-medium">{{ $item->comments_count }}</span>
                                        </div>
                                    </div>
                                    <a href="{{ route('thread.show', $item->id) }}"
                                        class="rounded-full bg-primary-50 px-4 py-2 text-sm font-medium text-primary-600 transition-colors hover:bg-primary-100 dark:bg-primary-900/30 dark:text-primary-400 dark:hover:bg-primary-900/50">
                                        Присоединиться
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="rounded-2xl bg-gray-50 p-12 text-center dark:bg-gray-800/50">
                    <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-16 w-16 text-gray-400" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                    </svg>
                    <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-white">
                        @if (auth()->check() && auth()->id() === $user->id)
                            У вас пока нет тем на форуме
                        @else
                            Пользователь пока не создавал тем
                        @endif
                    </h3>
                    <p class="mt-2 text-gray-500 dark:text-gray-400">
                        @if (auth()->check() && auth()->id() === $user->id)
                            Создайте первую тему и начните общение с сообществом!
                        @else
                            Пользователь еще не участвовал в обсуждениях
                        @endif
                    </p>
                    @if (auth()->check() && auth()->id() === $user->id)
                        <a href="{{ route('forum.index') }}"
                            class="mt-4 inline-flex items-center rounded-full bg-primary-600 px-4 py-2 text-sm font-medium text-white hover:bg-primary-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 h-4 w-4" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4v16m8-8H4" />
                            </svg>
                            Создать тему
                        </a>
                    @endif
                </div>
            @endif
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sortSelect = document.getElementById('trackSortSelect');
            const tracksContainer = document.getElementById('tracksContainer');

            sortSelect.addEventListener('change', function() {
                const sortType = this.value;
                const tracks = Array.from(tracksContainer.querySelectorAll('.track-item'));

                tracks.sort((a, b) => {
                    switch (sortType) {
                        case 'newest':
                            return parseInt(b.dataset.created) - parseInt(a.dataset.created);

                        case 'oldest':
                            return parseInt(a.dataset.created) - parseInt(b.dataset.created);

                        case 'popular':
                            return parseInt(b.dataset.favorites) - parseInt(a.dataset.favorites);

                        case 'alphabetical':
                            return a.dataset.title.localeCompare(b.dataset.title, 'ru');

                        default:
                            return 0;
                    }
                });

                // Очищаем контейнер и добавляем отсортированные треки
                tracksContainer.innerHTML = '';
                tracks.forEach(track => {
                    tracksContainer.appendChild(track);
                });

                // Добавляем анимацию появления
                tracks.forEach((track, index) => {
                    track.style.opacity = '0';
                    track.style.transform = 'translateY(20px)';

                    setTimeout(() => {
                        track.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
                        track.style.opacity = '1';
                        track.style.transform = 'translateY(0)';
                    }, index * 50);
                });
            });
        });
    </script>
@endsection
