<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coins extends Model
{
    use HasFactory;

    protected $fillable = [
        'coin_name', 
        'coin_code',
        'coin_wallet', 
        'coin_qr'
    ];
}
