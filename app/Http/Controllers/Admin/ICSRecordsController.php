<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use App\Http\Controllers\Security\AESCipher;

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
        $ics = ICS::where('icsNumber', 'like', '%'.session('search').'%')
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

    public function icsClear(Request $request)
    {
        $request->session()->put('search', '');

        return response()->json([
            'message' => 'success'
        ], 200);
    }
}
