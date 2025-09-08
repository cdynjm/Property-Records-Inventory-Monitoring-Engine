<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use App\Http\Controllers\Security\AESCipher;

use App\Models\Office;
use App\Models\ICS;

class OfficeRecordsController extends Controller
{
    protected AESCipher $aes;

    public function __construct(AESCipher $aes)
    {
        $this->aes = $aes;
    }

    public function index()
    {
        $offices = Office::orderBy('officeName', 'asc')
            ->get()->map(function ($office) {
            $office->encrypted_id = $this->aes->encrypt($office->id);
            return $office;
        });

        return view('pages.admin.office-records', [
            'offices' => $offices
        ]);
    }

    public function officeProperyInventoryRecords(Request $request)
    {
        $year = session('year');
        $search = session('search');
        $officeID = $this->aes->decrypt($request->encrypted_id);

        $ics = ICS::where('offices_id', $officeID)
        ->where('icsNumber', 'like', '%'.$search.'%')
        ->where('dateReceivedFrom', 'like', '%'.$year.'%')
        ->orderBy('updated_at', 'desc')->paginate(10)->through(function ($ics) {
            $ics->encrypted_id = $this->aes->encrypt($ics->id);
            return $ics;
        });

        $office = Office::where('id', $officeID)->first();

        return view('pages.admin.office-propery-inventory-records', [
            'ics' => $ics,
            'office' => $office
        ]);
    }
}
