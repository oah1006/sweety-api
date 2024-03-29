<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\Auth\UpdateProfileRequest;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function showProfile(Request $request) {
        $user = $request->user();

        return response()->json([
            'data' => $user
        ]);
    }

    public function update(UpdateProfileRequest $request) {
        $user = $request->user();

        $user->profile()->update($request->safe()->only(
            (new Customer)->getFillable()
        ));

        $user->update($request->safe()->only(
            (new User)->getFillable()
        ));

        $user = $user->fresh();

        return response()->json([
            'user' => $user
        ]);
    }
}
