<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageSetting extends Model
{
    protected $fillable = [
        'user_id',
        'page_url',
        'palette',
        'text_style',
        'components'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
