<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use App\Http\Controllers\Security\AESCipher;

use App\Models\ReceivedBy;

class PersonnelController extends Controller
{

    protected AESCipher $aes;

    public function __construct(AESCipher $aes)
    {
        $this->aes = $aes;
    }

    public function searchReceivedBy(Request $request)
    {
        $searchTerm = $request->input('search');

        $receivedBy = ReceivedBy::where('name', 'LIKE', '%' . $searchTerm . '%')
            ->limit(10)
            ->get()
            ->map(function ($rf) {
                $rf->encrypted_id = $this->aes->encrypt($rf->id);
                return $rf;
            });

        return response()->json($receivedBy);
    }
}
