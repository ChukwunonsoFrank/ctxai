<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class plans extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 
        'risk_type',
        'min_amount', 
        'max_amount',
        'min_roi_percentage',
        'max_roi_percentage',
        'order',
        'status',
        'image',
        'plan_duration',
    ];
}
