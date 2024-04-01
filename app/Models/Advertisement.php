<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Advertisement extends Model
{
    use HasFactory;

    protected $keyType = 'string';
    
    public $incrementing = false; 

    protected $fillable = ['title', 'description', 'price', 'type', 'image_path', 'user_id', 'einddatum', 'begin_huur', 'eind_huur', 'return_photo_path', 'renter_id', 'wear_level', 'link_ad'];
    protected $casts = [
        'begin_huur' => 'datetime',
        'eind_huur' => 'datetime',
        'einddatum' => 'datetime',
    ];
    
    protected static function boot()
    {
        parent::boot();    
        static::creating(function ($model) {
            $model->{$model->getKeyName()} = (string) Str::uuid();
        });

        static::creating(function ($advertisement) {
            $advertisement->einddatum = now()->addWeek();
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function renter()
    {
        return $this->belongsTo(User::class, 'renter_id');
    }

    public function purchasers()
    {   
        return $this->belongsToMany(User::class, 'sale_history', 'advertisement_id', 'user_id')->withTimestamps();
    }
    
    public function favoredByUsers()
    {
        return $this->belongsToMany(User::class, 'favorite_advertisements')->withTimestamps();
    }

    public function reviews()
    {
        return $this->hasMany(ProductReview::class);
    }

    public function highlightedByUsers()
    {
        return $this->belongsToMany(User::class, 'highlighted_ads', 'advertisement_id', 'user_id')->withTimestamps();
    }
}
