<?php
/**
**
 * MIT License
 *
 * Copyright (c) 2023 Linkyor
 *
**
 */

namespace App\Http\Controllers\Web\Account;

use App\Models\Item;
use App\Models\Inventory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PromocodesController extends Controller
{
    public function index()
    {
        $codes = config('promocodes');
        $items = [];

        foreach ($codes as $data) {
            $item = Item::where('id', '=', $data['item_id']);

            if ($item->exists()) {
                $item = $item->first();
                $item->coming_soon = $data['coming_soon'] ?? false;
                $item->leaving_soon = $data['leaving_soon'] ?? false;

                $items[] = $item;
            }
        }

        return view('web.account.promocodes')->with([
            'items' => $items
        ]);
    }

    public function redeem(Request $request)
    {
        $code = strtoupper($request->code);
        $codes = config('promocodes');

        if (!$request->has('code'))
            return response()->json(['error' => 'Please provide a code to redeem.']);

        if (!array_key_exists($code, $codes))
            return response()->json(['error' => "Invalid code. This code doesn't exist or has expired."]);

        $data = $codes[$code];
        $exists = Item::where('id', '=', $data['item_id'])->exists();

        if ((isset($data['coming_soon']) && $data['coming_soon']) || !$exists)
            return response()->json(['error' => "Invalid code. This code doesn't exist or has expired."]);

        $owns = Auth::user()->ownsItem($data['item_id']);

        if ($owns)
            return response()->json(['error' => 'This code has already been redeemed on your account.']);

        $inventory = new Inventory;
        $inventory->user_id = Auth::user()->id;
        $inventory->item_id = $data['item_id'];
        $inventory->save();

        return response()->json(['message' => 'This code has been successfully redeemed and the item provided has been added to your inventory.']);
    }
}
