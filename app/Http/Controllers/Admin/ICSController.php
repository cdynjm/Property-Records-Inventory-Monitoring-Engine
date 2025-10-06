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

        $data = [
            'offices_id' => $office->id, 
            'icsOffice' => $office->officeName, 
            'icsYear' => $request->icsYear, 
            'icsCode' => $request->icsCode, 
            'icsNumber' => $office->officeName . '-' . $request->icsYear . '-' . $request->icsCode,
            'receivedBy' => strtoupper($request->receivedBy),
            'receivedByPosition' => $request->receivedByPosition,
            'dateReceivedBy' => $request->dateReceivedBy,
            'receivedFrom_id' => $receivedFrom->id, 
            'receivedFromPosition' => $request->receivedFromPosition, 
            'dateReceivedFrom' => $request->dateReceivedFrom,
            'remarks' => 'active'
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

        $ics = ICS::create($data);

        $rows = $request->input('rows');
        
        foreach ($rows as $row) {
            ICSInformation::create([
                'ics_id' => $ics->id,
                'quantity' => $row['quantity'],
                'unit' => $row['unit'], 
                'officeCode' => $row['officeCode'],
                'invItemNumber' => $row['invItemNumber'],
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
            $ics->encrypted_receivedBy_id = $ics->receivedBy_id != null ? $this->aes->encrypt($ics->receivedBy_id) : '';
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

        $aes = $this->aes;

        return view('pages.admin.edit-ics', [
            'ics' => $ics,
            'offices' => $offices,
            'units' => $units,
            'receivedFrom' => $receivedFrom,
            'aes' => $aes,
        ]);
    }

    public function updateICS(Request $request)
    {
        $office = Office::where('id', $this->aes->decrypt($request->offices_id))->first();
        $receivedFrom = ReceivedFrom::where('id', $this->aes->decrypt($request->receivedFrom_id))->first();

        $icsId = $this->aes->decrypt($request->icsID);

        $data = [
            'offices_id' => $office->id,
            'icsOffice'  => $office->officeName,
            'icsYear' => $request->icsYear,
            'icsCode' => $request->icsCode,
            'icsNumber' => $office->officeName . '-' . $request->icsYear . '-' . $request->icsCode,
            'receivedBy' => strtoupper($request->receivedBy),
            'receivedByPosition' => $request->receivedByPosition,
            'dateReceivedBy' => $request->dateReceivedBy,
            'receivedFrom_id' => $receivedFrom->id,
            'receivedFromPosition' => $request->receivedFromPosition,
            'dateReceivedFrom' => $request->dateReceivedFrom,
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

        ICS::where('id', $icsId)->update($data);

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

        ICSInformation::where('ics_id', $icsId)
            ->whereNotIn('id', $submittedIds)
            ->delete();

        foreach ($rows as $row) {
            if (!empty($row['id'])) {
               
                ICSInformation::where('id', $this->aes->decrypt($row['id']))->update([
                    'quantity' => $row['quantity'],
                    'unit' => $row['unit'] ?? null, 
                    'officeCode' => $row['officeCode'],
                    'invItemNumber' => $row['invItemNumber'],
                    'dateAcquired' => $row['dateAcquired'],
                    'estUsefulLife' => $row['estUsefulLife'],
                    'unitCost' => $row['unitCost'],
                    'description' => $row['description'],
                ]);
            } else {
                
                ICSInformation::create([
                    'ics_id' => $icsId,
                    'quantity' => $row['quantity'],
                    'unit' => $row['unit'] ?? null, 
                    'officeCode' => $row['officeCode'],
                    'invItemNumber' => $row['invItemNumber'],
                    'dateAcquired' => $row['dateAcquired'],
                    'estUsefulLife' => $row['estUsefulLife'],
                    'unitCost' => $row['unitCost'],
                    'description' => $row['description'],
                ]);
            }
        }

        $request->session()->flash('success', 'ICS updated successfully.');

        return response()->json([
            'message' => 'ICS updated successfully.'
        ], 200);

    }

    public function deleteICS(Request $request)
    {
        $icsId = $this->aes->decrypt($request->icsID);

        ICSInformation::where('ics_id', $icsId)->delete();
        ICS::where('id', $icsId)->delete();

        $request->session()->flash('success', 'ICS deleted successfully.');

        return response()->json([
            'message' => 'ICS deleted successfully.'
        ], 200);
    }
}
