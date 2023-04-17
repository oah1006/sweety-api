<?php

namespace App\Http\Controllers\Province;

use App\Http\Controllers\Controller;
use App\Models\Ward;
use Illuminate\Http\Request;

class WardController extends Controller
{
    public function index(Request $request, $districtCode) {
        $wards = Ward::where('district_code', $districtCode)->get();

        return response()->json($wards);
    }
}
