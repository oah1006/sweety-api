<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\UpdateProfileRequest;
use App\Models\Staff;
use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function showProfile(Request $request) {
        $user = $request->user();

        return response()->json([
            'data' => [
                'id' => $user->id,
                'name' => $user->email,
                'fullname' => $user->profile->full_name
            ],
        ], 200);
    }

    public function update(UpdateProfileRequest $request) {
        $user = $request->user();

        $user->profile()->update($request->safe()->only(
            (new Staff)->getFillable()
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
