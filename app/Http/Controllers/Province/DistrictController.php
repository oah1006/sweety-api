<?php

namespace App\Http\Controllers\Province;

use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\Province;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class DistrictController extends Controller
{
    public function index(Request $request, $provinceCode) {
        $districts = District::where('province_code', $provinceCode)->get();

        return response()->json($districts);
    }
}
