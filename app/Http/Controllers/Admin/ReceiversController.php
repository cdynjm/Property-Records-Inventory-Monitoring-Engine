<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use App\Http\Controllers\Security\AESCipher;

use App\Models\ReceivedBy;

class ReceiversController extends Controller
{
    protected AESCipher $aes;

    public function __construct(AESCipher $aes)
    {
        $this->aes = $aes;
    }

    public function index()
    {
        $receivedBy = ReceivedBy::orderBy('name', 'asc')->paginate(10) ->through(function ($rb) {
            $rb->encrypted_id = $this->aes->encrypt($rb->id);
            return $rb;
        });
        
        return view('pages.admin.receivers', [
            'receivedBy' => $receivedBy,
        ]);
    }
}
