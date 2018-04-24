<?php

namespace App\Http\Controllers\Users\Followers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Models\User;

class FollowersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(User $user)
    {
        if (Auth::user()->id === $user->id) {
            return redirect()->back();
        }

        if (! Auth::user()->is_follow($user->id)) {
            Auth::user()->follow($user->id);
        }

        return redirect()->back();
    }

    public function destroy(User $user)
    {
        if (Auth::user()->id === $user->id) {
            return redirect()->back();
        }

        if (Auth::user()->is_follow($user->id)) {
            Auth::user()->unfollow($user->id);
        }

        return redirect()->back();
    }
}
