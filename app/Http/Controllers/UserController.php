<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //

    public function getuserdata(Request $request)
    {
        $user = User::with('roles')->find($request->user()->id);

        return response()->json([
            'user' => $user
        ]);
    }
}
