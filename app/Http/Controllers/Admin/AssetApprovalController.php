<?php
/**
**
 * MIT License
 *
 * Copyright (c) 2023 Linkyor
 *
**
 */

namespace App\Http\Controllers\Admin;

use App\Models\Clan;
use App\Models\Game;
use App\Models\Item;
use Illuminate\Http\Request;
use App\Models\AssetChecksum;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class AssetApprovalController extends Controller
{
    public function __construct()
    {
        $this->middleware(function($request, $next) {
            if (!staffUser()->staff('can_review_pending_assets')) abort(404);

            return $next($request);
        });
    }

    public function index(Request $request)
    {
        $storage = config('site.storage_url');
        $totalItems = Item::where('status', '=', 'pending')->whereIn('type', ['tshirt', 'shirt', 'pants'])->count();
        $totalLogos = Clan::where('is_thumbnail_pending', '=', true)->count();
        $totalThumbnails = Game::where('is_thumbnail_pending' ,'=', true)->count();

        switch ($request->category) {
            case '':
            case 'items':
                $category = 'items';
                $type = 'item';
                $assets = Item::where('status', '=', 'pending')->whereIn('type', ['tshirt', 'shirt', 'pants'])->orderBy('created_at', 'DESC')->paginate(12);

                foreach ($assets as $asset) {
                    $asset->image = "{$storage}/uploads/{$asset->filename}.png";
                    $asset->url = route('shop.item', $asset->id);
                    $asset->creator_url = route('users.profile', $asset->creator->id);
                    $asset->creator_name = $asset->creator->username;
                }
                break;
            case 'logos':
                $category = 'logos';
                $type = 'clan';
                $assets = Clan::where('is_thumbnail_pending', '=', true)->orderBy('created_at', 'DESC')->paginate(12);

                foreach ($assets as $asset) {
                    $asset->image = "{$storage}/thumbnails/{$asset->thumbnail}.png";
                    $asset->url = route('clans.view', $asset->id);
                    $asset->creator_url = route('users.profile', $asset->owner->id);
                    $asset->creator_name = $asset->owner->username;
                }
                break;
            case 'thumbnails':
                $category = 'thumbnails';
                $type = 'game';
                $assets = Game::where('is_thumbnail_pending', '=', true)->orderBy('created_at', 'DESC')->paginate(12);

                foreach ($assets as $asset) {
                    $asset->image = "{$storage}/thumbnails/{$asset->thumbnail}.png";
                    $asset->url = route('games.view', $asset->id);
                    $asset->creator_url = route('users.profile', $asset->creator->id);
                    $asset->creator_name = $asset->creator->username;
                }
                break;
            default:
                abort(404);
        }

        return view('admin.asset_approval')->with([
            'totalItems' => $totalItems,
            'totalLogos' => $totalLogos,
            'totalThumbnails' => $totalThumbnails,
            'category' => $category,
            'type' => $type,
            'assets' => $assets
        ]);
    }

    public function update(Request $request)
    {
        switch ($request->type) {
            case 'item':
                $item = Item::where('id', '=', $request->id)->whereIn('type', ['tshirt', 'shirt', 'pants'])->firstOrFail();
                $item->timestamps = false;
                $url = route('shop.item', $item->id);

                if ($item->status != 'pending')
                    return back()->withErrors(['This item has already been moderated.']);

                switch ($request->action) {
                    case 'approve':
                        render($item->id, 'item');

                        $item->status = 'approved';
                        $item->save();

                        if (Storage::exists("uploads/{$item->filename}.png")) {
                            $hash = md5_file(Storage::path("uploads/{$item->filename}.png"));
                            $hash = "{$item->type}_{$hash}";

                            $checksum = new AssetChecksum;
                            $checksum->item_id = $item->id;
                            $checksum->hash = $hash;
                            $checksum->save();
                        }

                        return back()->with('success_message', 'Item has been approved.');
                    case 'deny':
                        $item->status = 'declined';
                        $item->save();

                        if (Storage::exists("uploads/{$item->filename}.png")) {
                            $hash = md5_file(Storage::path("uploads/{$item->filename}.png"));
                            $hash = "{$item->type}_{$hash}";

                            $checksum = new AssetChecksum;
                            $checksum->item_id = $item->id;
                            $checksum->hash = $hash;
                            $checksum->save();
                        }

                        return back()->with('success_message', 'Item has been declined.');
                    default:
                        abort(404);
                }
            case 'clan':
                $clan = Clan::where('id', '=', $request->id)->firstOrFail();
                $clan->timestamps = false;

                if (!$clan->is_thumbnail_pending)
                    return back()->withErrors(['This logo has already been moderated.']);

                switch ($request->action) {
                    case 'approve':
                        $clan->is_thumbnail_pending = false;
                        $clan->save();

                        return back()->with('success_message', 'Logo has been approved.');
                    case 'deny':
                        if (Storage::exists("thumbnails/{$clan->thumbnail}.png"))
                            Storage::delete("thumbnails/{$clan->thumbnail}.png");

                        $clan->is_thumbnail_pending = false;
                        $clan->thumbnail = 'declined';
                        $clan->save();

                        return back()->with('success_message', 'Logo has been declined.');
                    default:
                        abort(404);
                }
            case 'game':
                $game = Game::where('id', '=', $request->id)->firstOrFail();
                $game->timestamps = false;

                if (!$game->is_thumbnail_pending)
                    return back()->withErrors(['This thumbnail has already been moderated.']);

                switch ($request->action) {
                    case 'approve':
                        $game->is_thumbnail_pending = false;
                        $game->save();

                        return back()->with('success_message', 'Thumbnail has been approved.');
                    case 'deny':
                        if (Storage::exists("thumbnails/{$game->thumbnail}.png"))
                            Storage::delete("thumbnails/{$game->thumbnail}.png");

                        $game->is_thumbnail_pending = false;
                        $game->thumbnail = 'declined';
                        $game->save();

                        return back()->with('success_message', 'Thumbnail has been declined.');
                    default:
                        abort(404);
                }
            default:
                abort(404);
        }
    }
}
