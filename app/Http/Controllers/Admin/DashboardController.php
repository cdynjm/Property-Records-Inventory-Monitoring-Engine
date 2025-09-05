<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\ICS;

class DashboardController extends Controller
{
    public function index()
    {
        $ics = ICS::count();
        return view('pages.admin.dashboard', ['ics' => $ics]);
    }
}
