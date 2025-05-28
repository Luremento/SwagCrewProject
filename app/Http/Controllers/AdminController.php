<?php

namespace App\Http\Controllers;

use App\Exports\TracksExport;
use App\Models\Comment;
use App\Models\Genre;
use App\Models\User;
use App\Models\Track;
use App\Models\Thread;
use App\Exports\UsersExport;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class AdminController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users' => User::count(),
            'total_tracks' => Track::count(),
            'total_threads' => Thread::count(),
            'total_comments' => Comment::count(),
            'new_users_today' => User::whereDate('created_at', today())->count(),
            'new_tracks_today' => Track::whereDate('created_at', today())->count(),
            'blocked_users' => User::where('is_blocked', true)->count(),
            'active_users' => User::where('created_at', '>=', Carbon::now()->subDays(30))->count(),
        ];

        $dailyStats = [];
        for ($i = 29; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $dailyStats[] = [
                'date' => $date->format('Y-m-d'),
                'users' => User::whereDate('created_at', $date)->count(),
                'tracks' => Track::whereDate('created_at', $date)->count(),
                'threads' => Thread::whereDate('created_at', $date)->count(),
            ];
        }

        $topGenres = Genre::withCount('tracks')
            ->orderBy('tracks_count', 'desc')
            ->limit(5)
            ->get();

        // Топ пользователи по трекам
        $topUsers = User::withCount('tracks')
            ->orderBy('tracks_count', 'desc')
            ->limit(5)
            ->get();

        // Последние пользователи
        $recentUsers = User::latest()->limit(5)->get();

        $recent_users = User::latest()->take(5)->get();
        $recent_tracks = Track::with('user')->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'stats',
            'recent_users',
            'recent_tracks',
            'stats',
            'dailyStats',
            'topGenres',
            'topUsers',
            'recentUsers'
        ));
    }

    public function users(Request $request)
    {
        $query = User::withCount(['tracks', 'threads', 'followers']);

        // Поиск
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Фильтр по роли
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        // Фильтр по статусу
        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('is_blocked', false);
            } elseif ($request->status === 'blocked') {
                $query->where('is_blocked', true);
            }
        }

        $users = $query->latest()->paginate(20);

        return view('admin.users', compact('users'));
    }

    public function toggleUserRole(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Нельзя изменить свою роль');
        }

        $user->role = $user->role === 'admin' ? 'user' : 'admin';
        $user->save();

        $message = $user->role === 'admin'
            ? "Пользователь {$user->name} назначен администратором"
            : "У пользователя {$user->name} отозваны права администратора";

        return back()->with('success', $message);
    }

    public function toggleUserBlock(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Нельзя заблокировать себя');
        }

        $user->is_blocked = !$user->is_blocked;
        $user->save();

        $message = $user->is_blocked
            ? "Пользователь {$user->name} заблокирован"
            : "Пользователь {$user->name} разблокирован";

        return back()->with('success', $message);
    }

    public function exportUsersExcel(Request $request)
    {
        $query = User::withCount(['tracks', 'threads', 'followers']);

        // Применяем те же фильтры, что и в списке
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('is_blocked', false);
            } elseif ($request->status === 'blocked') {
                $query->where('is_blocked', true);
            }
        }

        $users = $query->get();

        return Excel::download(
            new UsersExport($users),
            'users_' . date('Y-m-d_H-i-s') . '.xlsx'
        );
    }

    public function exportUsersPdf(Request $request)
    {
        $query = User::withCount(['tracks', 'threads', 'followers']);

        // Применяем те же фильтры
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('is_blocked', false);
            } elseif ($request->status === 'blocked') {
                $query->where('is_blocked', true);
            }
        }

        $users = $query->get();

        $pdf = Pdf::loadView('admin.reports.users-pdf', compact('users'));

        return $pdf->download('users_' . date('Y-m-d_H-i-s') . '.pdf');
    }

    public function exportTracksExcel()
    {
        $tracks = Track::with(['user', 'genre'])->get();

        return Excel::download(
            new TracksExport($tracks),
            'tracks_' . date('Y-m-d_H-i-s') . '.xlsx'
        );
    }
}
