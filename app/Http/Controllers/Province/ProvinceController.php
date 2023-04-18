<?php

namespace App\Http\Controllers\Province;

use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\Province;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ProvinceController extends Controller
{
    public function index(Request $request) {
        $province = Province::all();

        return response()->json([
            'data' => $province
        ]);
    }
}
