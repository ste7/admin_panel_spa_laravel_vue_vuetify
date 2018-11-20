<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePasswordRequest;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function me(Request $request) {
        return response()->json([
            'user' => $request->user()
        ], 200);
    }

    public function updatePassword(CreatePasswordRequest $request) {
        User::update($request->all());

        return response()->json([
            'data' => ''
        ], 200);
    }
}
