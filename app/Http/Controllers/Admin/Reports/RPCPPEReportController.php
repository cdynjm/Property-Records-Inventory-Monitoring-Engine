<?php

namespace App\Http\Controllers\Admin\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use App\Http\Controllers\Security\AESCipher;

use App\Models\Office;
use App\Models\Unit;
use App\Models\ReceivedFrom;
use App\Models\ReceivedBy;
use App\Models\ARE;
use App\Models\AREInformation;

class RPCPPEReportController extends Controller
{
    protected AESCipher $aes;

    public function __construct(AESCipher $aes)
    {
        $this->aes = $aes;
    }

    public function index(Request $request)
    {
        $are = ARE::get();
        return view('pages.admin.reports.rpcppe-report', ['are' => $are]);
    }
}
