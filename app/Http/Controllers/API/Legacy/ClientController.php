<?php
/**
**
 * MIT License
 *
 * Copyright (c) 2023 Linkyor
 *
**
 */

namespace App\Http\Controllers\API\Legacy;

use App\Models\Game;
use App\Models\User;
use App\Models\UserAvatar;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class ClientController extends Controller
{
    public function login(Request $request)
    {
        $user = User::where('username', '=', $request->username);

        if (!$user->exists())
            return 'ERROR Invalid username.';

        $user = $user->first();

        if (!password_verify($request->password, $user->password))
            return 'ERROR Incorrect password.';

        return "SUCCESS {$user->id}";
    }

    public function games(Request $request)
    {
        $games = Game::where('creator_id', '=', $request->id)->get();
        $output = '';

        foreach ($games as $game)
            $output .= "{$game->id} {$game->name}\n";

        return $output;
    }

    public function assetTexture(Request $request)
    {
        $file = "uploads/{$request->id}.png";

        if (!Storage::exists($file))
            return response('bruh', 404);

        return response(Storage::get($file), 200, ['Content-Type' => 'image/png']);
    }

    public function assetD3D(Request $request)
    {
        $file = "client/{$request->id}.d3d";

        if (!Storage::exists($file))
            return response('bruh', 404);

        return response(Storage::get($file), 200, ['Content-Type' => 'text/plain']);
    }

    public function getAvatar(Request $request)
    {
        $avatar = UserAvatar::where('user_id', '=', $request->id);

        if (!$avatar->exists())
            return response('bruh', 404);

        $avatar = $avatar->first();
        $array = [];

        $array[] = str_replace('#', '', $avatar->color_head);
        $array[] = str_replace('#', '', $avatar->color_torso);
        $array[] = str_replace('#', '', $avatar->color_right_arm);
        $array[] = str_replace('#', '', $avatar->color_left_arm);
        $array[] = str_replace('#', '', $avatar->color_right_leg);
        $array[] = str_replace('#', '', $avatar->color_left_leg);
        $array[] = $avatar->face ?? 0;
        $array[] = $avatar->shirt ?? 0;
        $array[] = $avatar->pants ?? 0;

        for ($i = 1; $i <= 5; $i++)
            $array[] = $avatar->{"hat_{$i}"} ?? 0;

        return implode(',', $array);
    }
}
