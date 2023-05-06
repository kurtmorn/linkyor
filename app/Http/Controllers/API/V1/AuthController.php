<?php
/**
**
 * MIT License
 *
 * Copyright (c) 2023 Linkyor
 *
**
 */

namespace App\Http\Controllers\API\V1;

use App\Models\Game;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function generateToken(Request $request)
    {
        $game = Game::where('id', '=', $request->set);

        if (!$game->exists())
            return response()->json([
                'error' => [
                    'message' => 'Record not found',
                    'prettyMessage' => 'Sorry, something went wrong'
                ]
            ]);

        $game = $game->first();

        return response()->json([
            'token' => (string) Auth::user()->id
        ]);
    }

    public function verifyToken(Request $request)
    {
        if (!$request->token)
            return response()->json([
                'error' => [
                    'message' => 'Missing parameters',
                    'prettyMessage' => 'Missing parameters'
                ]
            ]);

        $user = User::where('id', '=', $request->token);

        if (!$user->exists())
            return response()->json([
                'error' => 'Invalid token'
            ]);

        $user = $user->first();

        return response()->json([
            'validator' => null,
            'user' => [
                'id' => $user->id,
                'username' => $user->username,
                'is_admin' => $user->isStaff(),
                'membership' => [
                    'membership' => 1
                ]
            ]
        ]);
    }
}
