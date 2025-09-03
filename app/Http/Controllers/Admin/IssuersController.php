<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use App\Http\Controllers\Security\AESCipher;

use App\Models\ReceivedFrom;

class IssuersController extends Controller
{
    protected AESCipher $aes;

    public function __construct(AESCipher $aes)
    {
        $this->aes = $aes;
    }

    public function index()
    {
        $receivedFrom = ReceivedFrom::get()->map(function ($rf) {
            $rf->encrypted_id = $this->aes->encrypt($rf->id);
            return $rf;
        });
        
        return view('pages.admin.issuers', [
            'receivedFrom' => $receivedFrom,
        ]);
    }

    public function createIssuer(Request $request)
    {
        ReceivedFrom::create([
            'name' => strtoupper($request->name),
            'position' => $request->position,
        ]);

        $request->session()->flash('success', 'Issuer created successfully.');

        return response()->json([
            'message' => 'Issuer created successfully.'
        ], 200);
    }

    public function updateIssuer(Request $request)
    {
        ReceivedFrom::where('id', $this->aes->decrypt($request->issuerID))->update([
            'name' => strtoupper($request->name),
            'position' => $request->position,
        ]);

        $request->session()->flash('success', 'Issuer updated successfully.');

        return response()->json([
            'message' => 'Issuer updated successfully.'
        ], 200);
    }

    public function deleteIssuer(Request $request)
    {
        ReceivedFrom::where('id', $this->aes->decrypt($request->issuerID))->delete();

        $request->session()->flash('success', 'Issuer deleted successfully.');

        return response()->json([
            'message' => 'Issuer deleted successfully.'
        ], 200);
    }
}
