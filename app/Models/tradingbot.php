<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tradingbot extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'amount',
        'amount_earned',
        'duration',
        'duration_start',
        'duration_end',
        'strategy_id',
        'features',
        'profit_limit_exceed',
        'account_type',
        'status'
    ];
}
