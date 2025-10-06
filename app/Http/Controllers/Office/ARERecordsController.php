<?php

namespace App\Http\Controllers\Office;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use App\Http\Controllers\Security\AESCipher;

use App\Models\ARE;

class ARERecordsController extends Controller
{
    protected AESCipher $aes;

    public function __construct(AESCipher $aes)
    {
        $this->aes = $aes;
    }

    public function index()
    {
        $year = session('year');
        $search = session('search');

        $are = ARE::where('areControlNumber', 'like', '%'.$search.'%')
        ->where('offices_id', auth()->user()->office->id)
        ->where('dateReceivedFrom', 'like', '%'.$year.'%')
        ->orderBy('updated_at', 'desc')->paginate(15) ->through(function ($are) {
            $are->encrypted_id = $this->aes->encrypt($are->id);
            return $are;
        });

        return view('pages.office.are-records', [
            'are' => $are,
        ]);
    }
}
