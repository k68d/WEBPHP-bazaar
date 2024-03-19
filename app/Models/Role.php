<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    // Relationship with User
    public function users()
    {
        return $this->hasMany(User::class);
    }
}