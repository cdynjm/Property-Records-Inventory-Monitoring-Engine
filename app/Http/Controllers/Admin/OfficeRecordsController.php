<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Security\AESCipher;
use App\Traits\HasKeywordSearch;

use App\Models\Office;
use App\Models\ICS;
use App\Models\ARE;
use App\Models\User;

use App\Models\ICSInformation;
use App\Models\AREInformation;

class OfficeRecordsController extends Controller
{
    use HasKeywordSearch;
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

    public function officePropertyInventoryRecords(Request $request)
    {
        $year = session('year');
        $search = session('search');
        $officeID = $this->aes->decrypt($request->encrypted_id);

        $ics = $this->searchICS(
            ICS::where('offices_id', $officeID),
            $search,
            $year
        )->paginate(15)->through(function ($ics) {
            $ics->encrypted_id = $this->aes->encrypt($ics->id);
            return $ics;
        });

        $are = $this->searchARE(
            ARE::where('offices_id', $officeID),
            $search,
            $year
        )->paginate(15) ->through(function ($are) {
            $are->encrypted_id = $this->aes->encrypt($are->id);
            return $are;
        });

        $icsTotal = ICSInformation::whereHas('ics', function ($q) use($officeID) {
                $q->where('offices_id', $officeID);
            })
            ->where('dateAcquired', 'like', "{$year}%")
            ->count();

        $areTotal = AREInformation::whereHas('are', function ($q) use($officeID) {
                $q->where('offices_id', $officeID);
            })
            ->where('dateAcquired', 'like', "{$year}%")
            ->count();

        $office = Office::where('id', $officeID)->first();

        return view('pages.admin.office-property-inventory-records', [
            'ics' => $ics,
            'are' => $are,
            'office' => $office,
            'icsTotal' => $icsTotal,
            'areTotal' => $areTotal,
            
        ]);
    }

    public function createOffice(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|unique:users,email',
        ]);

        if ($validator->fails()) {
            
            return response()->json([
                'message' => 'Validation failed.',
                'errors' => $validator->errors()
            ], 500);
        }

        $office = Office::create([
            'officeName' => $request->officeName,
            'officeCode' => $request->officeCode,
        ]);

        User::create([
            'offices_id' => $office->id,
            'name' => $request->officeName,
            'email' => $request->username,
            'password' => Hash::make($request->password),
            'role' => 'office',
        ]);

        $request->session()->flash('success', 'Office created successfully.');

        return response()->json([
            'message' => 'Office created successfully.',
        ], 200);
    }

    public function updateOffice(Request $request)
    {
        $officeId = $this->aes->decrypt($request->officeID);

        $currentUser = User::where('offices_id', $officeId)->first();

        $validator = Validator::make($request->all(), [
            'username' => [
                'required',
                Rule::unique('users', 'email')->ignore($currentUser->id),
            ],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed.',
                'errors' => $validator->errors()
            ], 500);
        }

        Office::where('id', $officeId)->update([
            'officeName' => $request->officeName,
            'officeCode' => $request->officeCode,
        ]);

        User::where('offices_id', $officeId)->update([
            'name' => $request->officeName,
            'email' => $request->username,
        ]);

        if(!empty($request->password)) {
            User::where('offices_id', $officeId)->update([
                'password' => Hash::make($request->password),
            ]);
        }

        $request->session()->flash('success', 'Office updated successfully.');

        return response()->json([
            'message' => 'Office updated successfully.',
        ], 200);
    }

    public function deleteOffice(Request $request)
    {
        Office::where('id', $this->aes->decrypt($request->officeID))->delete();
        User::where('offices_id', $this->aes->decrypt($request->officeID))->delete();

        $request->session()->flash('success', 'Office deleted successfully.');

        return response()->json([
            'message' => 'Office deleted successfully.',
        ], 200);
    }
}
