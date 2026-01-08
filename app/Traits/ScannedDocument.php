<?php 
namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;

trait ScannedDocument
{
    protected function ValidateScannedDocument(Request $request): ?JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'scannedDocument' => 'nullable|file|mimes:pdf|max:2048',
        ]);

        if ($validator->fails()) {
            $message = $validator->errors()->first();

            $request->session()->flash('error', $message);

            return response()->json([
                'message' => $message,
                'errors'  => $validator->errors(),
            ], 422);
        }

        return null;
    }
}
