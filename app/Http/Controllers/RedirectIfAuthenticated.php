<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated extends Controller
{
    public function index()
    {
        // If not logged in, go to login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // If logged in, check role and redirect accordingly
        $user = Auth::user();

        if ($user->role == "superadmin") {
            return redirect()->route('superadmin.dashboard');
        }

        if ($user->role == "admin") {
            return redirect()->route('admin.dashboard');
        }

        if ($user->role == "office") {
            return redirect()->route('office.dashboard');
        }

        // fallback if no role matched
        abort(403, 'Unauthorized action.');
    }
}
