<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\ICS;
use App\Models\ARE;

class FileViewingController extends Controller
{
    /**
     * Show the scanned document for the given ICS record.
     *
     * @param string $filename
     * @return \Illuminate\Http\Response
     */
    public function viewICS(Request $request)
    {
        $ics = ICS::where('scannedDocument', $request->filename)->firstOrFail();

        $path = storage_path('app/private/scanned-documents/' . $request->filename);

        if (!file_exists($path)) {
            abort(404, 'File not found');
        }

        return response()->file($path);
    }

    public function viewARE(Request $request)
    {
        $ics = ARE::where('scannedDocument', $request->filename)->firstOrFail();

        $path = storage_path('app/private/scanned-documents/' . $request->filename);

        if (!file_exists($path)) {
            abort(404, 'File not found');
        }

        return response()->file($path);
    }
}
