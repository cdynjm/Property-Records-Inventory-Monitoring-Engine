<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use App\Http\Controllers\Security\AESCipher;

use App\Models\ReceivedBy;
use App\Models\ICS;

class ReceiversController extends Controller
{
    protected AESCipher $aes;

    public function __construct(AESCipher $aes)
    {
        $this->aes = $aes;
    }

    public function index()
    {
         $search = session('search-receiver');

        $receivedBy = ReceivedBy::where('name', 'like', '%'.$search.'%')
            ->orderBy('name', 'asc')->paginate(10) ->through(function ($rb) {
            $rb->encrypted_id = $this->aes->encrypt($rb->id);
            return $rb;
        });
        
        return view('pages.admin.receivers', [
            'receivedBy' => $receivedBy,
        ]);
    }

    public function receiversProperyInventoryRecords(Request $request)
    {
        $year = session('year');
        $search = session('search');
        $receivedByID = $this->aes->decrypt($request->encrypted_id);

        $ics = ICS::where('receivedBy_id', $receivedByID)
        ->where('icsNumber', 'like', '%'.$search.'%')
        ->where('dateReceivedFrom', 'like', '%'.$year.'%')
        ->orderBy('updated_at', 'desc')->paginate(10)->through(function ($ics) {
            $ics->encrypted_id = $this->aes->encrypt($ics->id);
            return $ics;
        });

        $receiver = ReceivedBy::where('id', $receivedByID)->first();

        return view('pages.admin.receivers-property-inventory-records', [
            'ics' => $ics,
            'receiver' => $receiver
        ]);
    }
}
