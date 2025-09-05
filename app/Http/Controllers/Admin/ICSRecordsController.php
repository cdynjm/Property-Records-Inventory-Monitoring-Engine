<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use App\Http\Controllers\Security\AESCipher;
use Carbon\Carbon;

use App\Models\ICS;

class ICSRecordsController extends Controller
{
    protected AESCipher $aes;

    public function __construct(AESCipher $aes)
    {
        $this->aes = $aes;
    }

    public function index()
    {
        $year = session('year') ?? Carbon::now()->year;
        $search = session('search');

        $ics = ICS::where('icsNumber', 'like', '%'.$search.'%')
        ->where('dateReceivedFrom', 'like', '%'.$year.'%')
        ->orderBy('updated_at', 'desc')->paginate(10) ->through(function ($ics) {
            $ics->encrypted_id = $this->aes->encrypt($ics->id);
            return $ics;
        });

        return view('pages.admin.ics-records', [
            'ics' => $ics,
        ]);
    }

    public function icsSearch(Request $request)
    {
        $request->session()->put('search', $request->search);

        return response()->json([
            'message' => 'success'
        ], 200);
    }

    public function icsYear(Request $request)
    {
        $request->session()->put('year', $request->year);

        return response()->json([
            'message' => 'success'
        ], 200);
    }

    public function icsSearchClear(Request $request)
    {
        $request->session()->put('search', '');

        return response()->json([
            'message' => 'success'
        ], 200);
    }

    public function icsYearClear(Request $request)
    {
        $request->session()->put('year', now()->year);

        return response()->json([
            'message' => 'success'
        ], 200);
    }
}
