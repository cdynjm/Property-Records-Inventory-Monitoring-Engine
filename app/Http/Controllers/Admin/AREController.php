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
use App\Models\AccountsCode;
use App\Models\ARE;
use App\Models\AREInformation;

class AREController extends Controller
{
    protected AESCipher $aes;

    public function __construct(AESCipher $aes)
    {
        $this->aes = $aes;
    }

    public function index()
    {
        $offices = Office::orderBy('officeName', 'asc')->get()->map(function ($office) {
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

        $accountsCode = AccountsCode::orderBy('propertyCode', 'asc')
        ->orderBy('propertySubCode', 'asc')->get()->map(function ($ac) {
            $ac->encrypted_id = $this->aes->encrypt($ac->id);
            return $ac;
        });

        return view('pages.admin.are', [
            'offices' => $offices,
            'units' => $units,
            'receivedFrom' => $receivedFrom,
            'accountsCode' => $accountsCode
        ]);
    }

    public function createARE(Request $request)
    {
        $office = Office::where('id', $this->aes->decrypt($request->offices_id))->first();
        $receivedFrom = ReceivedFrom::where('id', $this->aes->decrypt($request->receivedFrom_id))->first();

        $are = ARE::create([
            'offices_id' => $office->id, 
            'areOffice' => $office->officeName, 
            'areYear' => $request->areYear, 
            'areCode' => $request->areCode, 
            'areControlNumber' => $office->officeName . '-' . $request->areYear . '-' . $request->areCode,
            'receivedFrom_id' => $receivedFrom->id,
            'receivedFromPosition' => $receivedFrom->position,
            'dateReceivedFrom' => $request->dateReceivedFrom,
            'remarks' => 'active'
        ]);

        $rows = $request->input('rows');

        foreach ($request->rows as $row) {

            $accountsCode = AccountsCode::where('id', $this->aes->decrypt($row['account_codes_id']))->first();

            AREInformation::create([
                'are_id' => $are->id,
                'quantity' => $row['quantity'],
                'unit' => $row['unit'],
                'description' => $row['description'],
                'account_codes_id' => $accountsCode->id,
                'propertyYear' => date('Y', strtotime($row['dateAcquired'])),
                'propertyCode' => $accountsCode->propertyCode,
                'propertySubCode' => $accountsCode->propertySubCode,
                'propertyCount' => $row['propertyCount'],
                'propertyOffice' => $office->officeCode,
                'propertyNumber' => date('Y', strtotime($row['dateAcquired'])) . '-' . $accountsCode->propertyCode . '-' . $accountsCode->propertySubCode . '-' . $row['propertyCount'] . '-' . $office->officeCode,
                'unitCost' => $row['unitCost'],
                'totalValue' => $row['totalValue'],
                'dateAcquired' => $row['dateAcquired']
            ]);
        }

         $request->session()->flash('success', 'ARE created successfully.');

         return response()->json([
            'message' => 'ARE created successfully.'
        ], 200);
    }
}
