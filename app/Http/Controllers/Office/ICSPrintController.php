<?php

namespace App\Http\Controllers\Office;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use App\Http\Controllers\Security\AESCipher;

use App\Models\Office;
use App\Models\Unit;
use App\Models\ReceivedFrom;
use App\Models\ReceivedBy;
use App\Models\ICS;
use App\Models\ICSInformation;

class ICSPrintController extends Controller
{
    protected AESCipher $aes;

    public function __construct(AESCipher $aes)
    {
        $this->aes = $aes;
    }

    public function index(Request $request)
    {
        $icsID = $this->aes->decrypt($request->encrypted_id);
        $ics = ICS::where('id', $icsID)->select('icsNumber')->first();
        return view('pages.office.ics-print', [
            'encrypted_id' => $request->encrypted_id,
            'ics' => $ics
        ]);
    }
}
