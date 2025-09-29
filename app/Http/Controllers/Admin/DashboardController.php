<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\ICS;
use App\Models\ARE;

class DashboardController extends Controller
{
    public function index()
    {
        $year = session('year');

        $ics = ICS::where('dateReceivedFrom', 'like', '%'.$year.'%')->count();
        $are = ARE::where('dateReceivedFrom', 'like', '%'.$year.'%')->count();
        return view('pages.admin.dashboard', [
            'ics' => $ics,
            'are' => $are,
        ]);
    }
}
