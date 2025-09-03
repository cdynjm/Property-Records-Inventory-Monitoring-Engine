<?php

namespace App\Http\Controllers\Admin\Forms;

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

class ICSFormController extends Controller
{
    protected AESCipher $aes;

    public function __construct(AESCipher $aes)
    {
        $this->aes = $aes;
    }

    public function index(Request $request)
    {
        $ics = ICS::where('id', $this->aes->decrypt($request->encrypted_id))->first();

        return view('pages.admin.forms.ics-form', [
            'ics' => $ics
        ]);
    }
}
