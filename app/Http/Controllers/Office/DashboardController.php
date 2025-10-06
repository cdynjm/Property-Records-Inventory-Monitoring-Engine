<?php

namespace App\Http\Controllers\Office;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\ICS;
use App\Models\ARE;

class DashboardController extends Controller
{
    public function index()
    {
        $year = session('year');

        $ics = ICS::where('dateReceivedFrom', 'like', '%'.$year.'%')
        ->where('offices_id', auth()->user()->office->id)
        ->count();

        $are = ARE::where('dateReceivedFrom', 'like', '%'.$year.'%')
        ->where('offices_id', auth()->user()->office->id)
        ->count();

        return view('pages.office.dashboard', [
            'ics' => $ics,
            'are' => $are,
        ]);
    }
}
