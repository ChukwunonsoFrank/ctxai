<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class deposit extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 
        'gateway',
        'amount',
        'deposit_status'
    ];
}
