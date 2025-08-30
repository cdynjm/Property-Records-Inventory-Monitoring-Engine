<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Security\AESCipher;

use App\Models\Office;
use App\Models\User;

class AdminAccountController extends Controller
{
    protected AESCipher $aes;

    public function __construct(AESCipher $aes)
    {
        $this->aes = $aes;
    }

    public function index()
    {
        $admins = User::where('role', 'admin')->get()->map(function ($admin) {
            $admin->encrypted_id = $this->aes->encrypt($admin->id);
            return $admin;
        });

        return view('pages.superadmin.admin-accounts', [
            'admins' => $admins,
        ]);
    }

    public function createAdmin(Request $request)
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

        User::create([
            'name' => $request->name,
            'email' => $request->username,
            'password' => Hash::make($request->password),
            'role' => 'admin',
        ]);

        $request->session()->flash('success', 'Admin account created successfully.');

        return response()->json([
            'message' => 'Admin account created successfully.',
        ], 200);
    }

    public function updateAdmin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => [
                'required',
                Rule::unique('users', 'email')->ignore($this->aes->decrypt($request->adminID)),
            ],
        ]);

        if ($validator->fails()) {
            
            return response()->json([
                'message' => 'Validation failed.',
                'errors' => $validator->errors()
            ], 500);
        }

        User::where('id', $this->aes->decrypt($request->adminID))->update([
            'name' => $request->name,
            'email' => $request->username,
        ]);

        if(!empty($request->password)) {
            User::where('id', $this->aes->decrypt($request->adminID))->update([
                'password' => Hash::make($request->password),
            ]);
        }

         $request->session()->flash('success', 'Admin account updated successfully.');

         return response()->json([
            'message' => 'Admin account updated successfully.',
        ], 200);
    }

    public function deleteAdmin(Request $request)
    {
        User::where('id', $this->aes->decrypt($request->adminID))->delete();

        $request->session()->flash('success', 'Admin account deleted successfully.');

        return response()->json([
            'message' => 'Admin account deleted successfully.',
        ], 200);
    }
}
