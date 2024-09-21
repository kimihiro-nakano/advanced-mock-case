<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'shop_id',
        'reservation_id',
        'stars',
        'comment',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id')->select('id', 'name');
    }

    public function reservation()
    {
        return $this->belongsTo('App\Models\Reservation');
    }

    public function shop()
    {
        return $this->belongsTo('App\Models\Shop', 'shop_id');
    }
}
