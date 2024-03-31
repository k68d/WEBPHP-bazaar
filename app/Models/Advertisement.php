<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Advertisement extends Model
{
    use HasFactory;

    protected $keyType = 'string'; // Geef aan dat de sleuteltype een string is.
    public $incrementing = false; // Geen auto-increment.
    protected $fillable = ['title', 'description', 'price', 'type', 'image_path', 'user_id', 'begin_huur', 'eind_huur', 'return_photo_path', 'renter_id'];
    
    protected static function boot()
    {
        parent::boot();    
        static::creating(function ($model) {
            $model->{$model->getKeyName()} = (string) Str::uuid();
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
}
