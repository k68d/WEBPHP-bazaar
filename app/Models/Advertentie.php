<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Advertentie extends Model
{
    use HasFactory;

    protected $keyType = 'string'; // Geef aan dat de sleuteltype een string is.
    public $incrementing = false; // Geen auto-increment.
    protected $fillable = ['titel', 'beschrijving', 'prijs', 'type', 'afbeelding_path', 'user_id'];
    
    protected static function boot()
    {
        parent::boot();
    
        // Genereer een UUID wanneer er een nieuw model wordt aangemaakt.
        static::creating(function ($model) {
            $model->{$model->getKeyName()} = (string) Str::uuid();
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
