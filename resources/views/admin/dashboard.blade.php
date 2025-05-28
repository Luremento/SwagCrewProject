@extends('layouts.app')

@section('title', 'Панель администратора')

@section('content')
    <div class="space-y-8">
        <!-- Заголовок -->
        <div class="flex items-center justify-between">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Панель администратора</h1>
            <div class="flex space-x-3">
                <a href="{{ route('admin.users') }}"
                    class="rounded-lg bg-primary-600 px-4 py-2 text-white hover:bg-primary-700">
                    Управление пользователями
                </a>
            </div>
        </div>

        <!-- Статистические карточки -->
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
            <div class="rounded-xl bg-white p-6 shadow-lg dark:bg-gray-800">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-blue-500">
                            <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Всего пользователей</p>
                        <p class="text-2xl font-semibold text-gray-900 dark:text-white">
                            {{ number_format($stats['total_users']) }}</p>
                    </div>
                </div>
            </div>

            <div class="rounded-xl bg-white p-6 shadow-lg dark:bg-gray-800">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-green-500">
                            <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Всего треков</p>
                        <p class="text-2xl font-semibold text-gray-900 dark:text-white">
                            {{ number_format($stats['total_tracks']) }}</p>
                    </div>
                </div>
            </div>

            <div class="rounded-xl bg-white p-6 shadow-lg dark:bg-gray-800">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-purple-500">
                            <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Обсуждений</p>
                        <p class="text-2xl font-semibold text-gray-900 dark:text-white">
                            {{ number_format($stats['total_threads']) }}</p>
                    </div>
                </div>
            </div>

            <div class="rounded-xl bg-white p-6 shadow-lg dark:bg-gray-800">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-yellow-500">
                            <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Комментариев</p>
                        <p class="text-2xl font-semibold text-gray-900 dark:text-white">
                            {{ number_format($stats['total_comments']) }}</p>
                    </div>
                </div>
            </div>

            <div class="rounded-xl bg-white p-6 shadow-lg dark:bg-gray-800">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-indigo-500">
                            <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Активные (30 дней)</p>
                        <p class="text-2xl font-semibold text-gray-900 dark:text-white">
                            {{ number_format($stats['active_users']) }}</p>
                    </div>
                </div>
            </div>

            <div class="rounded-xl bg-white p-6 shadow-lg dark:bg-gray-800">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-red-500">
                            <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636m12.728 12.728L5.636 5.636" />
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Заблокированные</p>
                        <p class="text-2xl font-semibold text-gray-900 dark:text-white">
                            {{ number_format($stats['blocked_users']) }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- График активности -->
        <div class="rounded-xl bg-white p-6 shadow-lg dark:bg-gray-800">
            <h3 class="mb-4 text-lg font-semibold text-gray-900 dark:text-white">Активность за последние 30 дней</h3>
            <canvas id="activityChart" width="400" height="100"></canvas>
        </div>

        <!-- Топ контент -->
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
            <!-- Топ жанры -->
            <div class="rounded-xl bg-white p-6 shadow-lg dark:bg-gray-800">
                <h3 class="mb-4 text-lg font-semibold text-gray-900 dark:text-white">Популярные жанры</h3>
                <div class="space-y-3">
                    @foreach ($topGenres as $genre)
                        <div class="flex items-center justify-between">
                            <span class="text-gray-900 dark:text-white">{{ $genre->name }}</span>
                            <span
                                class="rounded-full bg-primary-100 px-2 py-1 text-sm text-primary-600 dark:bg-primary-900 dark:text-primary-400">
                                {{ $genre->tracks_count }} треков
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Топ пользователи -->
            <div class="rounded-xl bg-white p-6 shadow-lg dark:bg-gray-800">
                <h3 class="mb-4 text-lg font-semibold text-gray-900 dark:text-white">Активные пользователи</h3>
                <div class="space-y-3">
                    @foreach ($topUsers as $user)
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                @if ($user->avatar)
                                    <img src="{{ asset('storage/avatars/' . $user->avatar) }}" alt="Аватар"
                                        class="mr-3 h-8 w-8 rounded-full">
                                @else
                                    <img src="{{ asset('img/default-avatar.webp') }}" alt="Аватар"
                                        class="mr-3 h-8 w-8 rounded-full">
                                @endif
                                <span class="text-gray-900 dark:text-white">{{ $user->name }}</span>
                            </div>
                            <span
                                class="rounded-full bg-green-100 px-2 py-1 text-sm text-green-600 dark:bg-green-900 dark:text-green-400">
                                {{ $user->tracks_count }} треков
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Последние пользователи -->
        <div class="rounded-xl bg-white p-6 shadow-lg dark:bg-gray-800">
            <div class="mb-4 flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Последние регистрации</h3>
                <a href="{{ route('admin.users') }}"
                    class="text-primary-600 hover:text-primary-700 dark:text-primary-400">
                    Смотреть все
                </a>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead>
                        <tr>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                Пользователь
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                Email
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                Роль
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                Дата регистрации
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach ($recentUsers as $user)
                            <tr>
                                <td class="whitespace-nowrap px-6 py-4">
                                    <div class="flex items-center">
                                        @if ($user->avatar)
                                            <img src="{{ asset('storage/avatars/' . $user->avatar) }}" alt="Аватар"
                                                class="mr-3 h-8 w-8 rounded-full">
                                        @else
                                            <img src="{{ asset('img/default-avatar.webp') }}" alt="Аватар"
                                                class="mr-3 h-8 w-8 rounded-full">
                                        @endif
                                        <span class="text-gray-900 dark:text-white">{{ $user->name }}</span>
                                    </div>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-gray-500 dark:text-gray-400">
                                    {{ $user->email }}
                                </td>
                                <td class="whitespace-nowrap px-6 py-4">
                                    <span
                                        class="rounded-full px-2 py-1 text-xs font-medium {{ $user->role === 'admin' ? 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' : 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200' }}">
                                        {{ $user->role === 'admin' ? 'Администратор' : 'Пользователь' }}
                                    </span>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-gray-500 dark:text-gray-400">
                                    {{ $user->created_at->format('d.m.Y H:i') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('activityChart').getContext('2d');
            const dailyStats = @json($dailyStats);

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: dailyStats.map(stat => {
                        const date = new Date(stat.date);
                        return date.toLocaleDateString('ru-RU', {
                            month: 'short',
                            day: 'numeric'
                        });
                    }),
                    datasets: [{
                            label: 'Пользователи',
                            data: dailyStats.map(stat => stat.users),
                            borderColor: 'rgb(59, 130, 246)',
                            backgroundColor: 'rgba(59, 130, 246, 0.1)',
                            tension: 0.4
                        },
                        {
                            label: 'Треки',
                            data: dailyStats.map(stat => stat.tracks),
                            borderColor: 'rgb(16, 185, 129)',
                            backgroundColor: 'rgba(16, 185, 129, 0.1)',
                            tension: 0.4
                        },
                        {
                            label: 'Обсуждения',
                            data: dailyStats.map(stat => stat.threads),
                            borderColor: 'rgb(139, 92, 246)',
                            backgroundColor: 'rgba(139, 92, 246, 0.1)',
                            tension: 0.4
                        }
                    ]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    }
                }
            });
        });
    </script>
@endsection
