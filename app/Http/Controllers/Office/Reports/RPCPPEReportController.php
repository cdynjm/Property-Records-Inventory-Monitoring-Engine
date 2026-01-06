<?php

namespace App\Http\Controllers\Office\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use App\Http\Controllers\Security\AESCipher;
use App\Traits\HasKeywordSearch;

use App\Models\Office;
use App\Models\Unit;
use App\Models\ReceivedFrom;
use App\Models\ReceivedBy;
use App\Models\ARE;
use App\Models\AREInformation;

class RPCPPEReportController extends Controller
{
    use HasKeywordSearch;
    protected AESCipher $aes;

    public function __construct(AESCipher $aes)
    {
        $this->aes = $aes;
    }

    public function index(Request $request)
    {
        $year = session('rpcppe-year');
        $office = auth()->user()->office->id;
        $accountsCode = session('rpcppe-accounts-code');
        $request->session()->put('office-name', auth()->user()->office->officeName);

        $are = $this->searchRPCPPE(
            ARE::query(),
            $year != '' ? $year : date('Y'),
            $office,
            $accountsCode != '' ? $this->aes->decrypt($accountsCode) : $accountsCode
        )->get();

        return view('pages.office.reports.rpcppe-report', ['are' => $are]);
    }
}
