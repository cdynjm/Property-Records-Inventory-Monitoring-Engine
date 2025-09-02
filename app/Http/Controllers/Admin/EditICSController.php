<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use App\Http\Controllers\Security\AESCipher;

use App\Models\Office;
use App\Models\Unit;
use App\Models\ReceivedFrom;
use App\Models\ICS;
use App\Models\ICSInformation;

class EditICSController extends Controller
{
    protected AESCipher $aes;

    public function __construct(AESCipher $aes)
    {
        $this->aes = $aes;
    }

    public function index(Request $request)
    {
        $ics = ICS::where('id', $this->aes->decrypt($request->encrypted_id))->first();

        if ($ics) {
            $ics->encrypted_id = $this->aes->encrypt($ics->id);
            $ics->encrypted_offices_id = $this->aes->encrypt($ics->offices_id);
            $ics->encrypted_receivedFrom_id = $this->aes->encrypt($ics->receivedFrom_id);
        }

        $offices = Office::get()->map(function ($office) {
            $office->encrypted_id = $this->aes->encrypt($office->id);
            return $office;
        });

        $units = Unit::get()->map(function ($unit) {
            $unit->encrypted_id = $this->aes->encrypt($unit->id);
            return $unit;
        });

        $receivedFrom = ReceivedFrom::get()->map(function ($rf) {
            $rf->encrypted_id = $this->aes->encrypt($rf->id);
            return $rf;
        });

        return view('pages.admin.edit-ics', [
            'ics' => $ics,
            'offices' => $offices,
            'units' => $units,
            'receivedFrom' => $receivedFrom,
        ]);
    }
}
