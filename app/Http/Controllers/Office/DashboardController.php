<?php

namespace App\Http\Controllers\Office;

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

        $icsTotal = ICS::where('offices_id', auth()->user()->office->id)
            ->whereYear('dateReceivedFrom', $year)->count();

        $areTotal = ARE::where('offices_id', auth()->user()->office->id)
            ->whereYear('dateReceivedFrom', $year)->count();

        $icsMonthly = ICS::select(DB::raw('MONTH(dateReceivedFrom) as month'), DB::raw('count(*) as total'))
            ->where('offices_id', auth()->user()->office->id)
            ->whereYear('dateReceivedFrom', $year)
            ->groupBy('month')
            ->pluck('total', 'month')
            ->toArray();

        $areMonthly = ARE::select(DB::raw('MONTH(dateReceivedFrom) as month'), DB::raw('count(*) as total'))
            ->where('offices_id', auth()->user()->office->id)
            ->whereYear('dateReceivedFrom', $year)
            ->groupBy('month')
            ->pluck('total', 'month')
            ->toArray();

        $months = range(1, 12);
        $icsData = array_map(fn($m) => $icsMonthly[$m] ?? 0, $months);
        $areData = array_map(fn($m) => $areMonthly[$m] ?? 0, $months);

        return view('pages.office.dashboard', [
            'icsTotal' => $icsTotal,
            'areTotal' => $areTotal,
            'icsData' => json_encode($icsData),
            'areData' => json_encode($areData),
        ]);
    }
}
