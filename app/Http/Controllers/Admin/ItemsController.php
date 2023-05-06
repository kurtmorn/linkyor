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

use App\Models\Item;
use App\Models\User;
use App\Jobs\RenderUser;
use App\Models\UserAvatar;
use Illuminate\Http\Request;
use App\Models\AssetChecksum;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class ItemsController extends Controller
{
    public function __construct()
    {
        $this->middleware(function($request, $next) {
            if (!staffUser()->staff('can_view_item_info')) abort(404);

            return $next($request);
        });
    }

    public function index(Request $request)
    {
        $search = (isset($request->search)) ? trim($request->search) : '';
        $items = Item::where('name', 'LIKE', "%{$search}%")->orderBy('created_at', 'ASC')->paginate(25);

        return view('admin.items.index')->with([
            'search' => $search,
            'items' => $items ?? null
        ]);
    }

    public function view($id)
    {
        $item = Item::where('id', '=', $id)->firstOrFail();

        return view('admin.items.view')->with([
            'item' => $item
        ]);
    }

    public function update(Request $request)
    {
        $item = Item::where('id', '=', $request->id)->firstOrFail();
        $item->timestamps = false;

        switch ($request->action) {
            case 'status':
                if (!staffUser()->staff('can_review_pending_assets')) abort(404);

                $checksums = (in_array($item->type, ['tshirt', 'shirt', 'pants'])) ? Item::where('filename', '=', $item->filename)->get() : [];

                if (in_array($item->type, ['tshirt', 'shirt', 'pants'])) {
                    $hash = md5_file(Storage::path("uploads/{$item->filename}.png"));
                    $checksum = AssetChecksum::where('hash', '=', "{$item->type}_{$hash}");

                    if (!$checksum->exists()) {
                        $checksum = new AssetChecksum;
                        $checksum->item_id = $item->id;
                        $checksum->hash = $hash;
                        $checksum->save();
                    } else {
                        $checksum = $checksum->first();
                        $checksum->item_id = $item->id;
                        $checksum->save();
                    }
                }

                if ($item->status != 'approved') {
                    render($item->id, 'item');

                    if (!empty($checksums))
                        sleep(3);

                    $item->status = 'approved';
                    $item->save();

                    $thumbnail = Item::where('id', '=', $item->id)->first()->thumbnail_url;

                    foreach ($checksums as $checksum) {
                        if ($checksum->id != $item->id) {
                            $checksum->thumbnail_url = $thumbnail;
                            $checksum->status = 'approved';
                            $checksum->save();
                        }
                    }

                    return back()->with('success_message', 'Item has been approved.');
                }

                $file = "thumbnails/{$item->thumbnail_url}.png";

                $item->thumbnail_url = null;
                $item->status = 'declined';
                $item->save();

                foreach ($checksums as $checksum) {
                    if ($checksum->id != $item->id) {
                        $checksum->thumbnail_url = null;
                        $checksum->status = 'declined';
                        $checksum->save();
                    }
                }

                if (in_array($item->type, ['hat', 'head', 'face', 'tool', 'tshirt', 'shirt', 'pants'])) {
                    $avatars = UserAvatar::where(($item->type == 'hat') ? 'hat_1' : $item->type, '=', $item->id)->orWhere('hat_2', '=', $item->id)->orWhere('hat_3', '=', $item->id)->orWhere('hat_4', '=', $item->id)->orWhere('hat_5', '=', $item->id)->get();

                    foreach ($avatars as $avatar) {
                        $user = User::where('id', '=', $avatar->user_id)->first();

                        if ($user->isWearingItem($item->id)) {
                            $user->takeOffItem($item->id);

                            RenderUser::dispatch($user->id);
                        }

                    }

                    foreach ($checksums as $checksum) {
                        if ($checksum->id != $item->id) {
                            $avatars = UserAvatar::where(($checksum->type == 'hat') ? 'hat_1' : $item->type, '=', $checksum->id)->orWhere('hat_2', '=', $checksum->id)->orWhere('hat_3', '=', $checksum->id)->orWhere('hat_4', '=', $checksum->id)->orWhere('hat_5', '=', $checksum->id)->get();

                            foreach ($avatars as $avatar) {
                                $user = User::where('id', '=', $avatar->user_id)->first();

                                if ($user->isWearingItem($checksum->id)) {
                                    $user->takeOffItem($checksum->id);

                                    RenderUser::dispatch($user->id);
                                }
                            }
                        }
                    }
                }

                if (Storage::exists($file))
                    Storage::delete($file);

                return back()->with('success_message', 'Item has been declined.');
            case 'scrub':
                if (!staffUser()->staff('can_scrub_item_info')) abort(404);

                $item->scrub('name');
                $item->scrub('description');

                return back()->with('success_message', 'Item has been scrubbed.');
                break;
            case 'regen':
                if (!staffUser()->staff('can_render_thumbnails')) abort(404);

                $checksums = (in_array($item->type, ['tshirt', 'shirt', 'pants'])) ? Item::where('filename', '=', $item->filename)->get() : [];

                if (in_array($item->type, ['tshirt', 'shirt', 'pants'])) {
                    $hash = md5_file(Storage::path("uploads/{$item->filename}.png"));
                    $checksum = AssetChecksum::where('hash', '=', "{$item->type}_{$hash}");

                    if (!$checksum->exists()) {
                        $checksum = new AssetChecksum;
                        $checksum->item_id = $item->id;
                        $checksum->hash = $hash;
                        $checksum->save();
                    } else {
                        $checksum = $checksum->first();
                        $checksum->item_id = $item->id;
                        $checksum->save();
                    }
                }

                render($item->id, 'item');

                if (!empty($checksums)) {
                    sleep(3);

                    foreach ($checksums as $checksum) {
                        $thumbnail = Item::where('id', '=', $item->id)->first()->thumbnail_url;

                        if ($checksum->id != $item->id) {
                            $checksum->thumbnail_url = $thumbnail;
                            $checksum->save();
                        }
                    }
                }

                return back()->with('success_message', 'Item thumbnail has been regenerated.');
            default:
                abort(404);
        }
    }
}
