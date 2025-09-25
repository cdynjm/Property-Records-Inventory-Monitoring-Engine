<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Security\AESCipher;

use App\Models\AccountsCode;

class AccountsCodeController extends Controller
{
    protected AESCipher $aes;

    public function __construct(AESCipher $aes)
    {
        $this->aes = $aes;
    }

    public function index()
    {
        $accountsCode = AccountsCode::orderBy('propertyCode', 'asc')
        ->orderBy('propertySubCode', 'asc')
        ->get()->map(function ($ac) {
            $ac->encrypted_id = $this->aes->encrypt($ac->id);
            return $ac;
        });
        return view('pages.admin.accounts-code', [
            'accountsCode' => $accountsCode
        ]);
    }

    public function createAccountsCode(Request $request)
    {
        AccountsCode::create([
            'propertyCode' => $request->propertyCode,
            'propertySubCode' => $request->propertySubCode,
            'description' => $request->description
        ]);

         $request->session()->flash('success', 'Accounts code created successfully.');
    }

    public function updateAccountsCode(Request $request)
    {
        $accountID = $this->aes->decrypt($request->accountID);
        AccountsCode::where('id', $accountID)->update([
            'propertyCode' => $request->propertyCode,
            'propertySubCode' => $request->propertySubCode,
            'description' => $request->description
        ]);

         $request->session()->flash('success', 'Accounts code updated successfully.');
    }

    public function deleteAccountsCode(Request $request)
    {
        $accountID = $this->aes->decrypt($request->accountID);
        AccountsCode::where('id', $accountID)->delete();

         $request->session()->flash('success', 'Accounts code deleted successfully.');
    }
}
