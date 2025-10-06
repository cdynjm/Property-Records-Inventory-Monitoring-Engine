<?php

namespace App\Http\Controllers\Office\Forms;

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

class AREFormController extends Controller
{
    protected AESCipher $aes;

    public function __construct(AESCipher $aes)
    {
        $this->aes = $aes;
    }

    public function index(Request $request)
    {
        $are = ARE::where('id', $this->aes->decrypt($request->encrypted_id))->first();

        return view('pages.office.forms.are-form', [
            'are' => $are
        ]);
    }
}
