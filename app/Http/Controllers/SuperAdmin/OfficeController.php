<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use App\Http\Controllers\Security\AESCipher;

use App\Models\Office;

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
        
        Office::create([
            'officeName' => $request->officeName,
            'officeCode' => $request->officeCode,
        ]);

        $request->session()->flash('success', 'Office created successfully.');

        return response()->json([
            'message' => 'Office created successfully.',
        ], 200);
    }

    public function updateOffice(Request $request)
    {
        
        Office::where('id', $this->aes->decrypt($request->officeID))->update([
            'officeName' => $request->officeName,
            'officeCode' => $request->officeCode,
        ]);

        $request->session()->flash('success', 'Office updated successfully.');

        return response()->json([
            'message' => 'Office updated successfully.',
        ], 200);
    }

    public function deleteOffice(Request $request)
    {
        Office::where('id', $this->aes->decrypt($request->officeID))->delete();

        $request->session()->flash('success', 'Office deleted successfully.');

        return response()->json([
            'message' => 'Office deleted successfully.',
        ], 200);
    }
}
