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

class IPBan extends Model
{
    use HasFactory;

    protected $table = 'ip_bans';

    protected $fillable = [
        'banner_id',
        'ip'
    ];
}
