<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Shop extends Model
{
    use HasFactory;

    protected $fillable = [
        'shop',
        'location_id',
        'genre_id',
        'image',
        'overview',
    ];

    public function reservations()
    {
        return $this->hasMany('App\Models\Reservation');
    }
    public function favorites()
    {
        return $this->hasMany('App\Models\Favorite', 'shop_id');
    }

    public function location()
    {
        return $this->belongsTo('App\Models\Location');
    }
    public function genre()
    {
        return $this->belongsTo('App\Models\Genre');
    }

    public function checkIfUserFavorite()
    {
        $user = Auth::user();

        // ログインしていなければ、お気に入りの判定ができない
        if (!$user) {
            return false;
        }

        return $this->favorites()->where('user_id', $user->id)->exists();
    }
}
