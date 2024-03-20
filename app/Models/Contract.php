<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Contract extends Model
{
    use HasFactory;

    protected $fillable = ['user_id_one', 'user_id_two', 'description', 'contract_date', 'status', 'additional_info'];

    public function userOne()
    {
        return $this->belongsTo(User::class, 'user_id_one');
    }

    public function userTwo()
    {
        return $this->belongsTo(User::class, 'user_id_two');
    }
}
