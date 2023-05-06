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

class EmailVerifyHistory extends Model
{
    use HasFactory;

    protected $table = 'email_verify_history';

    protected $fillable = [
        'user_id',
        'code'
    ];
}
