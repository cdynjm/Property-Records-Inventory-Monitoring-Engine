<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LogoutController extends Controller
{
    public function index()
    {
        Auth::guard('web')->logout();

        Session::invalidate();
        Session::regenerateToken();

        return response()->json([
            'message' => 'Logged out successfully.'
        ], 200);
    }
}
