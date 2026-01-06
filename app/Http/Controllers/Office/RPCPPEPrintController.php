<?php

namespace App\Http\Controllers\Office;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Security\AESCipher;

use App\Models\ARE;
use App\Models\Office;
use App\Models\AccountsCode;


class RPCPPEPrintController extends Controller
{
    protected AESCipher $aes;

    public function __construct(AESCipher $aes)
    {
        $this->aes = $aes;
    }

    public function index()
    {
        
        $accountsCode = AccountsCode::orderBy('propertyCode', 'asc')
        ->orderBy('propertySubCode', 'asc')->get()->map(function ($ac) {
            $ac->encrypted_id = $this->aes->encrypt($ac->id);
            return $ac;
        });

        return view('pages.office.rpcppe-print', [
            'accountsCode' => $accountsCode
        ]);
    }
}
