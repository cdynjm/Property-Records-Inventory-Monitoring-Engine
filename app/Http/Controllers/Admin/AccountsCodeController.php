<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Security\AESCipher;

class AccountsCodeController extends Controller
{
    protected AESCipher $aes;

    public function __construct(AESCipher $aes)
    {
        $this->aes = $aes;
    }

    public function index()
    {
        return view('pages.admin.accounts-code');
    }
}
