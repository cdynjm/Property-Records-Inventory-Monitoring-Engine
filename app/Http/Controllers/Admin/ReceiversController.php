<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use App\Http\Controllers\Security\AESCipher;
use App\Traits\HasKeywordSearch;

use App\Models\ReceivedBy;
use App\Models\ICS;
use App\Models\ARE;

class ReceiversController extends Controller
{
    use HasKeywordSearch;
    protected AESCipher $aes;

    public function __construct(AESCipher $aes)
    {
        $this->aes = $aes;
    }

    public function index()
    {
         $search = session('search-receiver');

        $receivedBy = ReceivedBy::where('name', 'like', '%'.$search.'%')
            ->orderBy('name', 'asc')->paginate(15) ->through(function ($rb) {
            $rb->encrypted_id = $this->aes->encrypt($rb->id);
            return $rb;
        });
        
        return view('pages.admin.receivers', [
            'receivedBy' => $receivedBy,
        ]);
    }

    public function receiversPropertyInventoryRecords(Request $request)
    {
        $year = session('year');
        $search = session('search');
        $receivedByID = $this->aes->decrypt($request->encrypted_id);

        $ics = $this->searchICS(
            ICS::where('receivedBy_id', $receivedByID),
            $search,
            $year
        )->paginate(15)->through(function ($ics) {
            $ics->encrypted_id = $this->aes->encrypt($ics->id);
            return $ics;
        });

        $are = $this->searchARE(
            ARE::where('receivedBy_id', $receivedByID),
            $search,
            $year
        )->paginate(15) ->through(function ($are) {
            $are->encrypted_id = $this->aes->encrypt($are->id);
            return $are;
        });

        $receiver = ReceivedBy::where('id', $receivedByID)->first();

        return view('pages.admin.receivers-property-inventory-records', [
            'ics' => $ics,
            'are' => $are,
            'receiver' => $receiver
        ]);
    }
}
