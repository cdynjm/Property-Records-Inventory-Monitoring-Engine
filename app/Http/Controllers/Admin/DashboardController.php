<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\ICS;
use App\Models\ARE;

class DashboardController extends Controller
{
    public function index()
    {
        $year = session('year');

        $icsTotal = ICS::whereYear('dateReceivedFrom', $year)->count();
        $areTotal = ARE::whereYear('dateReceivedFrom', $year)->count();

        $icsMonthly = ICS::select(DB::raw('MONTH(dateReceivedFrom) as month'), DB::raw('count(*) as total'))
            ->whereYear('dateReceivedFrom', $year)
            ->groupBy('month')
            ->pluck('total', 'month')
            ->toArray();

        $areMonthly = ARE::select(DB::raw('MONTH(dateReceivedFrom) as month'), DB::raw('count(*) as total'))
            ->whereYear('dateReceivedFrom', $year)
            ->groupBy('month')
            ->pluck('total', 'month')
            ->toArray();

        $months = range(1, 12);
        $icsData = array_map(fn($m) => $icsMonthly[$m] ?? 0, $months);
        $areData = array_map(fn($m) => $areMonthly[$m] ?? 0, $months);

        return view('pages.admin.dashboard', [
            'icsTotal' => $icsTotal,
            'areTotal' => $areTotal,
            'icsData' => json_encode($icsData),
            'areData' => json_encode($areData),
        ]);
    }
}
