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
use App\Models\Item;
use App\Models\UserAvatar;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GamesController extends Controller
{
    public function info($id)
    {
        $game = Game::where('id', '=', $id);

        if (!$game->exists())
            return response()->json([
                'error' => [
                    'message' => 'Record not found',
                    'prettyMessage' => 'Sorry, something went wrong'
                ]
            ]);

        $game = $game->first();
        $image = $game->creator->avatar()->image;

        return response()->json([
            'data' => [
                'id' => $game->id,
                'creator' => [
                    'id' => $game->creator->username,
                    'username' => $game->creator->username,
                    'avatar_hash' => ($image == 'default') ? config('site.renderer.default_filename') : $image
                ],
                'name' => e($game->name),
                'description' => e($game->description),
                'playing' => $game->playing,
                'visits' => $game->visits,
                'created_at' => $game->created_at,
                'updated_at' => $game->updated_at
            ]
        ]);
    }

    public function retrieveAsset(Request $request)
    {
        if (!$request->id || !$request->type)
            return response()->json([
                'error' => [
                    'message' => 'Missing parameters',
                    'prettyMessage' => 'Missing parameters'
                ]
            ]);

        if (!in_array($request->type, ['png', 'obj']))
            return response()->json([
                'error' => [
                    'message' => "Invalid parameter {$request->type}",
                    'prettyMessage' => "Invalid parameter {$request->type}"
                ]
            ]);

        $asset = Item::where('id', '=', $request->id);

        if (!$asset->exists())
            return response()->json([
                'error' => [
                    'message' => 'Record not found',
                    'prettyMessage' => 'Sorry, something went wrong'
                ]
            ]);

        $asset = $asset->first();
        $url = config('site.storage_url');

        return redirect("{$url}/uploads/{$asset->filename}.{$request->type}");
    }

    public function retrieveAvatar(Request $request)
    {
        $avatar = UserAvatar::where('user_id', '=', $request->id);

        if (!$avatar->exists())
            return response()->json([
                'error' => [
                    'message' => 'Record not found',
                    'prettyMessage' => 'Sorry, something went wrong'
                ]
            ]);

        $avatar = $avatar->first();
        $hats = [];

        for ($i = 1; $i <= 5; $i++) {
            if ($avatar->{"hat_{$i}"})
                $hats[] = $avatar->{"hat_{$i}"};
        }

        return response()->json([
            'user_id' => $avatar->user_id,
            'items' => [
                'face' => $avatar->face ?? 0,
                'hats' => $hats,
                'tool' => $avatar->tool ?? 0,
                'pants' => $avatar->pants ?? 0,
                'shirt' => $avatar->shirt ?? 0,
                'figure' => $avatar->figure ?? 0,
            ],
            'colors' => [
                'head' => str_replace('#', '', $avatar->color_head),
                'torso' => str_replace('#', '', $avatar->color_torso),
                'left_arm' => str_replace('#', '', $avatar->color_left_arm),
                'left_leg' => str_replace('#', '', $avatar->color_left_leg),
                'right_arm' => str_replace('#', '', $avatar->color_right_arm),
                'right_leg' => str_replace('#', '', $avatar->color_right_leg)
            ]
        ]);
    }
}
