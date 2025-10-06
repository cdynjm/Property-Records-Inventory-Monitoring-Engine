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

use App\Models\AccountsCode;
use App\Models\ARE;

class AccountsCodeController extends Controller
{
     use HasKeywordSearch;
    protected AESCipher $aes;

    public function __construct(AESCipher $aes)
    {
        $this->aes = $aes;
    }

    public function index()
    {
        $accountsCode = AccountsCode::orderBy('propertyCode', 'asc')
        ->orderBy('propertySubCode', 'asc')
        ->paginate(15)->through(function ($ac) {
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

    public function accountsCodePropertyInventoryRecords(Request $request)
    {
        $year = session('year');
        $search = session('search');
        $accountCodeID = $this->aes->decrypt($request->encrypted_id);

        $accountsCode = AccountsCode::where('id', $accountCodeID)->first();

        $are = $this->searchARE(
            ARE::whereHas('information', function ($query) use ($accountCodeID) {
                $query->where('account_codes_id', $accountCodeID);
            })->where('dateReceivedFrom', 'like', '%'.$year.'%'),
            $search
        )
            ->orderBy('updated_at', 'desc')
            ->with(['information' => function ($query) use ($accountCodeID) {
                $query->where('account_codes_id', $accountCodeID)
                    ->with('accountsCode');
            }])
            ->paginate(15)
            ->through(function ($are) {
                $are->encrypted_id = $this->aes->encrypt($are->id);
                return $are;
            });

        return view('pages.admin.accounts-code-property-inventory-records', [
            'are' => $are,
            'accountsCode' => $accountsCode
        ]);
    }
}
