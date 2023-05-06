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

class Status extends Model
{
    use HasFactory;

    protected $table = 'statuses';

    protected $fillable = [
        'creator_id',
        'message',
        'created_at',
        'updated_at'
    ];

    public function creator()
    {
        return $this->belongsTo('App\Models\User', 'creator_id');
    }
}
