<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdvertiserReview extends Model
{
    use HasFactory;
    protected $fillable = [
        'advertiser_id', 
        'reviewer_id', 
        'review', 
        'rating',
    ];
}
