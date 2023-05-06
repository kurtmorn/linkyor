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

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemPurchase extends Model
{
    use HasFactory;

    protected $table = 'item_purchases';

    protected $fillable = [
        'seller_id',
        'buyer_id',
        'item_id',
        'ip',
        'currency_used',
        'price'
    ];

    public function seller()
    {
        return $this->belongsTo('App\Models\User', 'seller_id');
    }

    public function buyer()
    {
        return $this->belongsTo('App\Models\User', 'buyer_id');
    }

    public function item()
    {
        return $this->belongsTo('App\Models\Item', 'item_id');
    }
}
