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

        $data = [
            'offices_id' => $office->id, 
            'areOffice' => $office->officeName, 
            'areYear' => $request->areYear, 
            'areCode' => $request->areCode, 
            'areControlNumber' => $office->officeName . '-' . $request->areYear . '-' . $request->areCode,
            'receivedBy' => strtoupper($request->receivedBy),
            'receivedByPosition' => $request->receivedByPosition,
            'dateReceivedBy' => $request->dateReceivedBy,
            'receivedFrom_id' => $receivedFrom->id,
            'receivedFromPosition' => $request->receivedFromPosition,
            'dateReceivedFrom' => $request->dateReceivedFrom,
            'remarks' => $request->remarks
        ];

        if (!empty($request->receivedBy_id)) {
            $data['receivedBy_id'] = $this->aes->decrypt($request->receivedBy_id);
        
            ReceivedBy::where('id', $data['receivedBy_id'])->update([
                'name'     => strtoupper($request->receivedBy),
                'position' => $request->receivedByPosition,
            ]);

        } else {
            if(!empty($request->receivedBy)) {
                $receivedBy = ReceivedBy::create([
                    'name'     => strtoupper($request->receivedBy),
                    'position' => $request->receivedByPosition,
                ]);

                $data['receivedBy_id'] = $receivedBy->id;
            } else {
                $data['receivedBy_id'] = null;
            }
        }
        
        $are = ARE::create($data);
        
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

         $request->session()->flash('success', 'ARE and PPE created successfully.');

         return response()->json([
            'message' => 'ARE and PPE created successfully.'
        ], 200);
    }

    public function editARE(Request $request)
    {
        $are = ARE::where('id', $this->aes->decrypt($request->encrypted_id))->first();

        if ($are) {
            $are->encrypted_id = $this->aes->encrypt($are->id);
            $are->encrypted_offices_id = $this->aes->encrypt($are->offices_id);
            $are->encrypted_receivedFrom_id = $this->aes->encrypt($are->receivedFrom_id);
            $are->encrypted_receivedBy_id = $are->receivedBy_id != null ? $this->aes->encrypt($are->receivedBy_id) : '';
        }

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

        $aes = $this->aes;

        return view('pages.admin.edit-are', [
            'are' => $are,
            'offices' => $offices,
            'units' => $units,
            'receivedFrom' => $receivedFrom,
            'accountsCode' => $accountsCode,
            'aes' => $aes
        ]);
    }

    public function updateARE(Request $request)
    {
         $office = Office::where('id', $this->aes->decrypt($request->offices_id))->first();
         $receivedFrom = ReceivedFrom::where('id', $this->aes->decrypt($request->receivedFrom_id))->first();

         $AreId = $this->aes->decrypt($request->areID);

         $data = [
            'offices_id' => $office->id, 
            'areOffice' => $office->officeName, 
            'areYear' => $request->areYear, 
            'areCode' => $request->areCode, 
            'areControlNumber' => $office->officeName . '-' . $request->areYear . '-' . $request->areCode,
            'receivedBy' => strtoupper($request->receivedBy),
            'receivedByPosition' => $request->receivedByPosition,
            'dateReceivedBy' => $request->dateReceivedBy,
            'receivedFrom_id' => $receivedFrom->id,
            'receivedFromPosition' => $request->receivedFromPosition,
            'dateReceivedFrom' => $request->dateReceivedFrom,
            'remarks' => $request->remarks
         ];

         if (!empty($request->receivedBy_id)) {
            $data['receivedBy_id'] = $this->aes->decrypt($request->receivedBy_id);
        
            ReceivedBy::where('id', $data['receivedBy_id'])->update([
                'name'     => strtoupper($request->receivedBy),
                'position' => $request->receivedByPosition,
            ]);

        } else {
            if(!empty($request->receivedBy)) {
                $receivedBy = ReceivedBy::create([
                    'name'     => strtoupper($request->receivedBy),
                    'position' => $request->receivedByPosition,
                ]);

                $data['receivedBy_id'] = $receivedBy->id;
            } else {
                $data['receivedBy_id'] = null;
            }
        }

        ARE::where('id', $AreId)->update($data);

        $rows = $request->input('rows', []);
        $submittedIds = collect($rows)
        ->pluck('id')
        ->filter()
        ->map(function ($id) {
            try {
                return $this->aes->decrypt($id);
            } catch (\Exception $e) {
                return null;
            }
        })
        ->filter()
        ->toArray();

        AREInformation::where('are_id', $AreId)
            ->whereNotIn('id', $submittedIds)
            ->delete();

        foreach ($rows as $row) {

            $accountsCode = AccountsCode::where('id', $this->aes->decrypt($row['account_codes_id']))->first();

            if (!empty($row['id'])) {
               
                AREInformation::where('id', $this->aes->decrypt($row['id']))->update([
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
            } else {
                
                AREInformation::create([
                    'are_id' => $AreId,
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
        }

        $request->session()->flash('success', 'PPE updated successfully.');

        return response()->json([
            'message' => 'ARE and PPE updated successfully.'
        ], 200);
    }

    public function deleteARE(Request $request)
    {
        $areId = $this->aes->decrypt($request->areID);

        AREInformation::where('are_id', $areId)->delete();
        ARE::where('id', $areId)->delete();

        $request->session()->flash('success', 'ARE and PPE deleted successfully.');

        return response()->json([
            'message' => 'ARE and PPE deleted successfully.'
        ], 200);
    }
}
