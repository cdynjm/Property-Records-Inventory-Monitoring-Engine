<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Security\AESCipher;
use Session;
use App\Traits\HasKeywordSearch;

use App\Models\ICS;
use App\Models\ARE;

class DashboardController extends Controller
{
    use HasKeywordSearch;
    protected AESCipher $aes;

    public function __construct(AESCipher $aes)
    {
        $this->aes = $aes;
    }

    public function index()
    {
        $year = session('year');
        $search = session('search');

        $icsTotal = ICS::whereHas('information', function ($query) use ($year) {
                $query->where('dateAcquired', 'like', "{$year}%");
            })->count();

        $areTotal = ARE::whereHas('information', function ($query) use ($year) {
                $query->where('dateAcquired', 'like', "{$year}%");
            })->count();

       /* $icsMonthly = ICS::select(DB::raw('MONTH(dateReceivedFrom) as month'), DB::raw('count(*) as total'))
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
        $areData = array_map(fn($m) => $areMonthly[$m] ?? 0, $months); */

        $are = $this->searchARE(
            ARE::query(),
            $search,
            $year
        )
        ->orderBy('updated_at', 'desc')->paginate(15) ->through(function ($are) {
            $are->encrypted_id = $this->aes->encrypt($are->id);
            return $are;
        });

        return view('pages.admin.dashboard', [
            'icsTotal' => $icsTotal,
            'areTotal' => $areTotal,
           // 'icsData' => json_encode($icsData),
           // 'areData' => json_encode($areData),
            'are' => $are
        ]);
    }
}
