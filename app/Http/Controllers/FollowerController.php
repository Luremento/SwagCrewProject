<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class FollowerController extends Controller
{
    public function follow(User $user)
    {
        if (Auth::id() !== $user->id && !Auth::user()->following->contains($user->id)) {
            Auth::user()->following()->attach($user->id);
        }

        return redirect()->back();
    }

    public function unfollow(User $user)
    {
        if (Auth::id() !== $user->id && Auth::user()->following->contains($user->id)) {
            Auth::user()->following()->detach($user->id);
        }

        return redirect()->back();
    }
}
