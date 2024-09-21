<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function addFavorite(Request $request, Shop $shop)
    {
        if (!Auth::check()) {
            return response()->json(['status' => 'unauthenticated', 'message' => 'ログインが必要です。'], 401);
        }

        $user = Auth::user();

        $exists = Favorite::where('user_id', $user->id)
            ->where('shop_id', $shop->id)
            ->exists();

        if (!$exists) {
            Favorite::create([
                'user_id' => $user->id,
                'shop_id' => $shop->id,
            ]);

            return response()->json(['status' => 'added']);
        }

        return response()->json(['status' => 'already_exists']);
    }

    public function removeFavorite(Request $request, Shop $shop)
    {
        if (!Auth::check()) {
            return response()->json(['status' => 'unauthenticated', 'message' => 'ログインが必要です。'], 401);
        }

        $user = Auth::user();

        $favorite = Favorite::where('user_id', $user->id)
            ->where('shop_id', $shop->id)
            ->first();

        if ($favorite) {
            $favorite->delete();
            return response()->json(['status' => 'removed']);
        }

        return response()->json(['status' => 'does_not_exist']);
    }
}
