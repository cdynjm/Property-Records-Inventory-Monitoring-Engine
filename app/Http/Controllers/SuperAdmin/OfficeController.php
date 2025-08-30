<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Security\AESCipher;

use App\Models\Office;
use App\Models\User;

class OfficeController extends Controller
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

        return view('pages.superadmin.offices', [
            'offices' => $offices,
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
