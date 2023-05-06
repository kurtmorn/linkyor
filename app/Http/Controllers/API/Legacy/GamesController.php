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
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class GamesController extends Controller
{
    public function publish(Request $request)
    {
        $game = Game::where('id', '=', $request->id);

        if (!$game->exists())
            return response('bruh', 404);

        $game = $game->first();

        if ($request->hasFile('thumbnail')) {
            $filename = Str::random(50);

            if (Storage::exists("thumbnails/games/{$game->thumbnail}.png"))
                Storage::delete("thumbnails/games/{$game->thumbnail}.png");

            $game->thumbnail = $filename;

            $thumbnail = imagecreatefromstring($request->file('thumbnail')->get());
            $img = imagecreatetruecolor(892, 640);

            imagealphablending($img, false);
            imagesavealpha($img, true);
            imagefilledrectangle($img, 0, 0, 892, 640, imagecolorallocatealpha($img, 255, 255, 255, 127));
            imagecopyresampled($img, $thumbnail, 0, 0, 0, 0, 892, 640, imagesx($thumbnail), imagesy($thumbnail));

            $thumbnail = $img;
            imagealphablending($thumbnail, false);
            imagesavealpha($thumbnail, true);

            if (!Storage::exists('thumbnails/games/'))
                Storage::makeDirectory('thumbnails/games/');

            Storage::put("thumbnails/games/{$filename}.png", Image::make($thumbnail)->encode('png'));
        }

        $game->save();

        return 'SUCCESS';
    }

    public function upload(Request $request)
    {
        $game = Game::where('id', '=', $request->id);

        if (!$game->exists())
            return response('bruh', 404);

        $game = $game->first();

        if ($request->hasFile('brk')) {
            if (!Storage::exists('brks'))
                Storage::makeDirectory('brks');

            Storage::put("brks/{$game->id}.brk", $request->file('brk')->get());
        }

        return 'SUCCESS';
    }
}
