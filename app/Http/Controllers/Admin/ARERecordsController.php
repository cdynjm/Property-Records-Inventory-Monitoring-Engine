<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use App\Http\Controllers\Security\AESCipher;
use App\Traits\HasKeywordSearch;

use App\Models\ARE;

class ARERecordsController extends Controller
{
    use HasKeywordSearch;
    protected AESCipher $aes;

    public function __construct(AESCipher $aes)
    {
        $this->aes = $aes;
    }

    public function index()
    {
        $year = session('year');
        $search = session('search');

        $are = $this->searchARE(
            ARE::where('dateReceivedFrom', 'like', "%{$year}%"),
            $search
        )
        ->orderBy('updated_at', 'desc')->paginate(15) ->through(function ($are) {
            $are->encrypted_id = $this->aes->encrypt($are->id);
            return $are;
        });

        return view('pages.admin.are-records', [
            'are' => $are,
        ]);
    }
}
