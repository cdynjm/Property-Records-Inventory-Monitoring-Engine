<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use App\Http\Controllers\Security\AESCipher;

use App\Models\Office;
use App\Models\Unit;
use App\Models\ReceivedFrom;
use App\Models\ReceivedBy;
use App\Models\ICS;
use App\Models\ICSInformation;

class ICSController extends Controller
{
    protected AESCipher $aes;

    public function __construct(AESCipher $aes)
    {
        $this->aes = $aes;
    }

    public function index()
    {
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

        return view('pages.admin.ics', [
            'offices' => $offices,
            'units' => $units,
            'receivedFrom' => $receivedFrom,
        ]);
    }

    public function createICS(Request $request) 
    {
        $office = Office::where('id', $this->aes->decrypt($request->offices_id))->first();
        $receivedFrom = ReceivedFrom::where('id', $this->aes->decrypt($request->receivedFrom_id))->first();

        $ics = ICS::create([
            'offices_id' => $office->id, 
            'icsOffice' => $office->officeName, 
            'icsYear' => $request->icsYear, 
            'icsCode' => $request->icsCode, 
            'icsNumber' => $office->officeName . '-' . $request->icsYear . '-' . $request->icsCode,
            'receivedFrom_id' => $receivedFrom->id, 
            'receivedFromPosition' => $receivedFrom->position, 
            'dateReceivedFrom' => $request->dateReceivedFrom,
            'furnishedBy' => $request->furnishedBy, 
            'remarks' => 'active'
        ]);

        $rows = $request->input('rows');
        
        foreach ($rows as $row) {
            ICSInformation::create([
                'ics_id' => $ics->id,
                'quantity' => $row['quantity'],
                'unit' => $row['unit'], 
                'officeCode' => $row['officeCode'],
                'invItemNumber' => $office->officeName . '-' . $request->icsYear . '-' . $office->officeCode,
                'dateAcquired' => $row['dateAcquired'],
                'estUsefulLife' => $row['estUsefulLife'],
                'unitCost' => $row['unitCost'],
                'description' => $row['description'],
            ]);
        }

        $request->session()->flash('success', 'ICS created successfully.');

        return response()->json([
            'message' => 'ICS created successfully.'
        ], 200);
    }

    public function editICS(Request $request)
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

    public function searchReceivedBy(Request $request)
    {
        $searchTerm = $request->input('search');

        $receivedBy = ReceivedBy::where('name', 'LIKE', '%' . $searchTerm . '%')
            ->get()
            ->map(function ($rf) {
                $rf->encrypted_id = $this->aes->encrypt($rf->id);
                return $rf;
            });

        return response()->json($receivedBy);
    }

    public function updateICS(Request $request)
    {
        
    }
}
