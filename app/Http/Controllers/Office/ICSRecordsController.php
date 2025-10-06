<?php

namespace App\Http\Controllers\Office;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use App\Http\Controllers\Security\AESCipher;
use App\Traits\HasKeywordSearch;

use App\Models\ICS;

class ICSRecordsController extends Controller
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

        $ics = $this->searchICS(
            ICS::where('offices_id', auth()->user()->office->id)
                ->where('dateReceivedFrom', 'like', '%'.$year.'%'),
            $search
        )
        ->orderBy('updated_at', 'desc')->paginate(15) ->through(function ($ics) {
            $ics->encrypted_id = $this->aes->encrypt($ics->id);
            return $ics;
        });

        return view('pages.office.ics-records', [
            'ics' => $ics,
        ]);
    }
}
