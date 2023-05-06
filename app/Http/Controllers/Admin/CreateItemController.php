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

use Carbon\Carbon;
use App\Models\Item;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class CreateItemController extends Controller
{
    public function index($type)
    {
        switch ($type) {
            case 'hat':
                $title = 'Create New Hat';

                if (!staffUser()->staff('can_create_hat_items')) abort(404);
                break;
            case 'face':
                $title = 'Create New Face';

                if (!staffUser()->staff('can_create_face_items')) abort(404);
                break;
            case 'tool':
                $title = 'Create New Tool';

                if (!staffUser()->staff('can_create_tool_items')) abort(404);
                break;
            default:
                abort(404);
        }

        return view('admin.create_item')->with([
            'title' => $title,
            'type' => $type
        ]);
    }

    public function create(Request $request)
    {
        if (
            !in_array($request->type, ['hat', 'face', 'tool']) ||
            (!staffUser()->staff('can_create_hat_items') && $request->type == 'hat') ||
            (!staffUser()->staff('can_create_face_items') && $request->type == 'face') ||
            (!staffUser()->staff('can_create_tool_items') && $request->type == 'tool')
        ) abort(404);

        $onsale = $request->has('onsale');
        $official = $request->has('official');
        $public = $request->has('public');
        $auto = $request->has('auto');
        $special = $request->has('special');
        $filename = Str::random(50);
        $validate = [];

        if (!$auto) {
            $validate['name'] = ['required', 'min:1', 'max:70'];
            $validate['description'] = ['max:1024'];
        }


        $validate['image'] = ($request->type != 'face') ? ['mimes:png,jpg,jpeg', 'max:2048'] : ['required', 'mimes:png,jpg,jpeg', 'max:2048'];

        if ($request->type != 'face')
            $validate['model'] = ['required', 'mimes:txt', 'max:2048'];

        if ($onsale) {
            $validate['price_bits'] = ['required', 'numeric', 'min:0', 'max:1000000'];
            $validate['price_bucks'] = ['required', 'numeric', 'min:0', 'max:1000000'];
        }

        if ($special)
            $validate['stock'] = ['required', 'numeric', 'min:0', 'max:500'];

        $this->validate($request, $validate);

        switch ($request->onsale_for) {
            case '1_hour':
                $time = 3600;
                break;
            case '12_hours':
                $time = 43200;
                break;
            case '1_day':
                $time = 86400;
                break;
            case '3_days':
                $time = 259200;
                break;
            case '7_days':
                $time = 604800;
                break;
            case '14_days':
                $time = 1209600;
                break;
            case '21_days':
                $time = 1814400;
                break;
            case '1_month':
                $time = 2592000;
                break;
        }

        $item = new Item;
        $item->creator_id = (!$official) ? staffUser()->id : 1;
        $item->name = $request->name;
        $item->description = $request->description;
        $item->type = $request->type;
        $item->status = 'approved';
        $item->price_bits = ($onsale) ? $request->price_bits : 0;
        $item->price_bucks = ($onsale) ? $request->price_bucks : 0;
        $item->special_type = ($special) ? 'special_edition' : null;
        $item->stock = ($special) ? $request->stock : 0;
        $item->public_view = $public;
        $item->onsale = $onsale;
        $item->filename = $filename;
        $item->onsale_until = ($onsale && isset($time)) ? Carbon::createFromTimestamp(time() + $time)->format('Y-m-d H:i:s') : null;
        $item->save();

        if ($request->hasFile('image'))
            Storage::putFileAs('uploads', $request->file('image'), "{$filename}.png");

        if ($item->type != 'face')
            Storage::putFileAs('uploads', $request->file('model'), "{$filename}.obj");

        render($item->id, 'item');

        return redirect()->route('shop.item', $item->id);
    }
}
