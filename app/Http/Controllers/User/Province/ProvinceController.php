<?php

namespace App\Http\Controllers\User\Province;

use App\Http\Controllers\Controller;
use App\Models\Province;
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
