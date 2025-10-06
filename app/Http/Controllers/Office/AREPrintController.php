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
use App\Models\ARE;
use App\Models\AREInformation;

class AREPrintController extends Controller
{
    protected AESCipher $aes;

    public function __construct(AESCipher $aes)
    {
        $this->aes = $aes;
    }

    public function index(Request $request)
    {
        $areID = $this->aes->decrypt($request->encrypted_id);
        $are = ARE::where('id', $areID)->select('areControlNumber')->first();
        return view('pages.office.are-print', [
            'encrypted_id' => $request->encrypted_id,
            'are' => $are
        ]);
    }
}
