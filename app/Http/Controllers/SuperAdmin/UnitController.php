<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use App\Http\Controllers\Security\AESCipher;

use App\Models\Unit;

class UnitController extends Controller
{
    protected AESCipher $aes;

    public function __construct(AESCipher $aes)
    {
        $this->aes = $aes;
    }

    public function index()
    {
        $units = Unit::get()->map(function ($unit) {
            $unit->encrypted_id = $this->aes->encrypt($unit->id);
            return $unit;
        });

        return view('pages.superadmin.unit', [
            'units' => $units,
        ]);
    }

    public function createUnit(Request $request)
    {

        Unit::create([
            'unit' => $request->unitName,
        ]);

        $request->session()->flash('success', 'Unit created successfully.');

        return response()->json([
            'message' => 'Unit created successfully.',
        ], 200);
    }

    public function updateUnit(Request $request)
    {

        Unit::where('id', $this->aes->decrypt($request->unitID))->update([
            'unit' => $request->unitName,
        ]);

        $request->session()->flash('success', 'Unit updated successfully.');

        return response()->json([
            'message' => 'Unit updated successfully.',
        ], 200);
    }

    public function deleteUnit(Request $request)
    {

        Unit::where('id', $this->aes->decrypt($request->unitID))->delete();

        $request->session()->flash('success', 'Unit deleted successfully.');

        return response()->json([
            'message' => 'Unit deleted successfully.',
        ], 200);
    }
}
