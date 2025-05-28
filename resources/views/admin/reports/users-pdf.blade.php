<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Отчет по пользователям</title>
    <style>
        @page {
            margin: 15mm;
            size: A4 landscape;
            /* Альбомная ориентация для широких таблиц */
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 10px;
            line-height: 1.3;
            margin: 0;
            padding: 0;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }

        .header h1 {
            margin: 0 0 10px 0;
            font-size: 18px;
            color: #333;
        }

        .header p {
            margin: 5px 0;
            color: #666;
            font-size: 10px;
        }

        .stats {
            display: flex;
            justify-content: space-around;
            margin-bottom: 20px;
            background-color: #f8f9fa;
            padding: 10px;
            border-radius: 5px;
        }

        .stat-item {
            text-align: center;
        }

        .stat-number {
            font-size: 16px;
            font-weight: bold;
            color: #2563eb;
        }

        .stat-label {
            font-size: 9px;
            color: #666;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            font-size: 9px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 6px 4px;
            text-align: left;
            vertical-align: top;
            word-wrap: break-word;
        }

        th {
            background-color: #f8f9fa;
            font-weight: bold;
            color: #333;
            font-size: 8px;
            text-transform: uppercase;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .status-active {
            color: #059669;
            font-weight: bold;
        }

        .status-blocked {
            color: #dc2626;
            font-weight: bold;
        }

        .role-admin {
            color: #dc2626;
            font-weight: bold;
        }

        .role-user {
            color: #6b7280;
        }

        /* Ширины колонок */
        .col-id {
            width: 5%;
        }

        .col-name {
            width: 15%;
        }

        .col-email {
            width: 20%;
        }

        .col-role {
            width: 10%;
        }

        .col-status {
            width: 10%;
        }

        .col-tracks {
            width: 8%;
        }

        .col-threads {
            width: 8%;
        }

        .col-followers {
            width: 8%;
        }

        .col-date {
            width: 16%;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .footer {
            position: fixed;
            bottom: 10mm;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 8px;
            color: #666;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>Отчет по пользователям</h1>
        <p>Сгенерирован: {{ date('d.m.Y H:i:s') }}</p>

        <div class="stats">
            <div class="stat-item">
                <div class="stat-number">{{ $users->count() }}</div>
                <div class="stat-label">Всего пользователей</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">{{ $users->where('role', 'admin')->count() }}</div>
                <div class="stat-label">Администраторов</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">{{ $users->where('is_blocked', true)->count() }}</div>
                <div class="stat-label">Заблокированных</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">{{ $users->where('is_blocked', false)->count() }}</div>
                <div class="stat-label">Активных</div>
            </div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th class="col-id">ID</th>
                <th class="col-name">Имя</th>
                <th class="col-email">Email</th>
                <th class="col-role text-center">Роль</th>
                <th class="col-status text-center">Статус</th>
                <th class="col-tracks text-center">Треков</th>
                <th class="col-threads text-center">Тем</th>
                <th class="col-followers text-center">Подписчиков</th>
                <th class="col-date">Регистрация</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td class="text-center">{{ $user->id }}</td>
                    <td>{{ Str::limit($user->name, 20) }}</td>
                    <td>{{ Str::limit($user->email, 25) }}</td>
                    <td class="text-center {{ $user->role === 'admin' ? 'role-admin' : 'role-user' }}">
                        {{ $user->role === 'admin' ? 'Админ' : 'Польз.' }}
                    </td>
                    <td class="text-center {{ $user->is_blocked ? 'status-blocked' : 'status-active' }}">
                        {{ $user->is_blocked ? 'Блок' : 'Актив' }}
                    </td>
                    <td class="text-center">{{ $user->tracks_count ?? 0 }}</td>
                    <td class="text-center">{{ $user->threads_count ?? 0 }}</td>
                    <td class="text-center">{{ $user->followers_count ?? 0 }}</td>
                    <td>{{ $user->created_at->format('d.m.Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Страница <span class="pagenum"></span> из <span class="pagecount"></span> | Музыкальная платформа -
        Административный отчет
    </div>
</body>

</html>
