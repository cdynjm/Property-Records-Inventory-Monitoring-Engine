<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use App\Http\Controllers\Security\AESCipher;

use App\Models\Office;
use App\Models\AccountsCode;

class SearchController extends Controller
{
    protected AESCipher $aes;

    public function __construct(AESCipher $aes)
    {
        $this->aes = $aes;
    }
    
    public function search(Request $request)
    {
        $request->session()->put('search', $request->search);

        return response()->json([
            'message' => 'success'
        ], 200);
    }

    public function year(Request $request)
    {
        $request->session()->put('year', $request->year);

        return response()->json([
            'message' => 'success'
        ], 200);
    }

    public function searchReceiver(Request $request)
    {
        $request->session()->put('search-receiver', $request->search);

        return response()->json([
            'message' => 'success'
        ], 200);
    }

    public function searchClear(Request $request)
    {
        $request->session()->put('search', '');

        return response()->json([
            'message' => 'success'
        ], 200);
    }

    public function yearClear(Request $request)
    {
        $request->session()->put('year', now()->year);

        return response()->json([
            'message' => 'success'
        ], 200);
    }

    public function clearReceiver(Request $request)
    {
        $request->session()->put('search-receiver', '');

        return response()->json([
            'message' => 'success'
        ], 200);
    }

    public function searchRPCPPE(Request $request) 
    {
        $request->session()->put('rpcppe-year', $request->year);
        $request->session()->put('rpcppe-office', $request->office);
        $request->session()->put('rpcppe-accounts-code', $request->accountsCode);

        $accountsCodeId = $this->aes->decrypt($request->accountsCode);
        $officeId = $this->aes->decrypt($request->office);

        $accountsCode = AccountsCode::where('id', $accountsCodeId)->value('description');
        $office = Office::where('id', $officeId)->value('officeName');

        $request->session()->put('accounts-code-description', $accountsCode);
        $request->session()->put('office-name', $office);

        return response()->json([
            'message' => 'success'
        ], 200);
    }
}
