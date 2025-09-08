<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $request->session()->put('search', $request->search);

        return response()->json([
            'message' => 'success'
        ], 200);
    }

    public function year(Request $request)
    {
        $request->session()->put('year', $request->year);

        return response()->json([
            'message' => 'success'
        ], 200);
    }

    public function searchClear(Request $request)
    {
        $request->session()->put('search', '');

        return response()->json([
            'message' => 'success'
        ], 200);
    }

    public function yearClear(Request $request)
    {
        $request->session()->put('year', now()->year);

        return response()->json([
            'message' => 'success'
        ], 200);
    }
}
