@extends('layouts.app')

@section('title', 'Управление пользователями')

@section('content')
    <div class="space-y-6">
        <!-- Заголовок и действия -->
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('admin.export.users.excel', request()->all()) }}"
                class="rounded-lg bg-green-600 px-4 py-2 text-white hover:bg-green-700">
                <svg class="mr-2 inline h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Excel
            </a>
            <a href="{{ route('admin.export.users.pdf', request()->all()) }}"
                class="rounded-lg bg-red-600 px-4 py-2 text-white hover:bg-red-700">
                <svg class="mr-2 inline h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                PDF
            </a>
        </div>

        <!-- Фильтры -->
        <div class="rounded-xl bg-white p-6 shadow-lg dark:bg-gray-800">
            <form method="GET" class="grid grid-cols-1 gap-4 md:grid-cols-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Поиск</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Имя или email..."
                        class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Роль</label>
                    <select name="role"
                        class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700">
                        <option value="">Все роли</option>
                        <option value="user" {{ request('role') === 'user' ? 'selected' : '' }}>Пользователь</option>
                        <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Администратор</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Статус</label>
                    <select name="status"
                        class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700">
                        <option value="">Все статусы</option>
                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Активные</option>
                        <option value="blocked" {{ request('status') === 'blocked' ? 'selected' : '' }}>Заблокированные
                        </option>
                    </select>
                </div>

                <div class="flex items-end">
                    <button type="submit"
                        class="w-full rounded-lg bg-primary-600 px-4 py-2 text-white hover:bg-primary-700">
                        Применить
                    </button>
                </div>
            </form>
        </div>

        <!-- Таблица пользователей -->
        <div class="overflow-hidden rounded-xl bg-white shadow-lg dark:bg-gray-800">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                Пользователь
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                Статистика
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                Роль
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                Статус
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                Регистрация
                            </th>
                            <th
                                class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                Действия
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white dark:divide-gray-700 dark:bg-gray-800">
                        @foreach ($users as $user)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                <td class="whitespace-nowrap px-6 py-4">
                                    <div class="flex items-center">
                                        @if ($user->avatar)
                                            <img src="{{ asset('storage/avatars/' . $user->avatar) }}" alt="Аватар"
                                                class="mr-4 h-10 w-10 rounded-full">
                                        @else
                                            <img src="{{ asset('img/default-avatar.webp') }}" alt="Аватар"
                                                class="mr-4 h-10 w-10 rounded-full">
                                        @endif
                                        <div>
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                {{ $user->name }}</div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">{{ $user->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4">
                                    <div class="text-sm text-gray-900 dark:text-white">
                                        <div>Треков: {{ $user->tracks_count }}</div>
                                        <div>Тем: {{ $user->threads_count }}</div>
                                        <div>Подписчиков: {{ $user->followers_count }}</div>
                                    </div>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4">
                                    <span
                                        class="inline-flex rounded-full px-2 text-xs font-semibold leading-5 {{ $user->role === 'admin' ? 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' : 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200' }}">
                                        {{ $user->role === 'admin' ? 'Админ' : 'Пользователь' }}
                                    </span>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4">
                                    <span
                                        class="inline-flex rounded-full px-2 text-xs font-semibold leading-5 {{ $user->is_blocked ? 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' : 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' }}">
                                        {{ $user->is_blocked ? 'Заблокирован' : 'Активен' }}
                                    </span>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                    {{ $user->created_at->format('d.m.Y H:i') }}
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-right text-sm font-medium">
                                    <div class="flex justify-end space-x-2">
                                        @if ($user->id !== auth()->id())
                                            <form action="{{ route('admin.users.toggle-role', $user) }}" method="POST"
                                                class="inline">
                                                @csrf
                                                <button type="submit"
                                                    class="rounded bg-blue-600 px-3 py-1 text-xs text-white hover:bg-blue-700"
                                                    onclick="return confirm('Изменить роль пользователя?')">
                                                    {{ $user->role === 'admin' ? 'Снять админа' : 'Сделать админом' }}
                                                </button>
                                            </form>

                                            <form action="{{ route('admin.users.toggle-block', $user) }}" method="POST"
                                                class="inline">
                                                @csrf
                                                <button type="submit"
                                                    class="rounded px-3 py-1 text-xs text-white {{ $user->is_blocked ? 'bg-green-600 hover:bg-green-700' : 'bg-red-600 hover:bg-red-700' }}"
                                                    onclick="return confirm('{{ $user->is_blocked ? 'Разблокировать' : 'Заблокировать' }} пользователя?')">
                                                    {{ $user->is_blocked ? 'Разблокировать' : 'Заблокировать' }}
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Пагинация -->
            <div class="bg-white px-4 py-3 dark:bg-gray-800">
                {{ $users->links() }}
            </div>
        </div>
    </div>
@endsection
