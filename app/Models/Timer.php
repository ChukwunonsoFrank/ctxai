<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Timer extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 
        'asset_name',
        'asset_display_name',
        'percentage', 
        'image_url',
        'action',
        'timer_starts_at',
        'timer_ends_at',
        'is_timer_running'
    ];
}
