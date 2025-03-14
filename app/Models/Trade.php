<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trade extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'bot_id',
        'trades',
        'total_amount_earned',
        'stopped_robot_at_position'
    ];
}
