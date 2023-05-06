<?php
/**
**
 * MIT License
 *
 * Copyright (c) 2023 Linkyor
 *
**
 */

namespace App\Models;

use App\Models\Inventory;
use App\Models\ItemComment;
use App\Models\ItemFavorite;
use App\Models\ItemPurchase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Item extends Model
{
    use HasFactory;

    protected $table = 'items';

    protected $fillable = [
        'creator_id',
        'name',
        'description',
        'type',
        'status',
        'price_bits',
        'price_bucks',
        'special_type',
        'stock',
        'public_view',
        'onsale',
        'thumbnail_url',
        'filename',
        'onsale_until',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'onsale_until' => 'datetime'
    ];

    public function creator()
    {
        return $this->belongsTo('App\Models\User', 'creator_id');
    }

    public function thumbnail()
    {
        $url = config('site.storage_url');

        if ($this->status != 'approved')
            return "{$url}/default/{$this->status}.png";

        $time = time();
        $filename = "{$url}/thumbnails/{$this->thumbnail_url}.png";

        if ($this->thumbnail_url == $this->id)
            $filename .= "?cb={$time}";

        return $filename;
    }

    public function isTimed()
    {
        return !empty($this->onsale_until) && strtotime($this->onsale_until) > time();
    }

    public function onsale()
    {
        if ($this->onsale_until && strtotime($this->onsale_until) < time())
            return false;

        if ($this->special_type && $this->stock < 1)
            return false;

        return $this->onsale;
    }

    public function owners()
    {
        return Inventory::where('item_id', '=', $this->id)->get();
    }

    public function sold()
    {
        return ItemPurchase::where('item_id', '=', $this->id)->get();
    }

    public function favorites()
    {
        return ItemFavorite::where('item_id', '=', $this->id)->get();
    }

    public function resellers()
    {
        return ItemReseller::where('item_id', '=', $this->id)->orderBy('price', 'ASC')->paginate(10);
    }

    public function comments($hasPagination = true)
    {
        if (Auth::check() && Auth::user()->isStaff())
            $comments = ItemComment::where('item_id', '=', $this->id)->orderBy('created_at', 'DESC');
        else
            $comments = ItemComment::where([
                ['item_id', '=', $this->id],
                ['is_deleted', '=', false]
            ])->orderBy('created_at', 'DESC');

        return ($hasPagination) ? $comments->paginate(10) : $comments->get();
    }

    public function recentAveragePrice()
    {
        $purchases = ItemPurchase::where('item_id', '=', $this->id);
        $average = 0;

        if ($purchases->count() > 0)
            $average = $purchases->avg('price');

        return (integer) $average;
    }

    public function scrub($column)
    {
        $this->timestamps = false;

        switch ($column) {
            case 'name':
            case 'description':
                $this->$column = '[ Content Removed ]';
                $this->save();
                break;
        }
    }

    public function notifyWebhooks($isNew)
    {
        // fix later
        // if ($this->public_view)
            // NotifyWebhooks::dispatch($this->id, $isNew);
    }
}
