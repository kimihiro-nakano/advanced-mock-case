<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shop;
use App\Models\Location;
use App\Models\Genre;
use App\Models\Review;
use Illuminate\Support\Facades\Redis;

class ShopController extends Controller
{
    public function index()
    {
        $shops = Shop::with(['location', 'genre'])->get();

        $shops->each(function ($shop) {
            $shop->checkIfUserFavorite = $shop->checkIfUserFavorite();
        });

        $locations = Location::all();
        $genres = Genre::all();

        return view('shops', compact('shops', 'locations', 'genres'));
    }

    public function search(Request $request)
    {
        // dd($request->all());

        if ($request->has('reset')) {
            return redirect()->route('search');
        }

        $query = Shop::query();

        if ($request->filled('location_id')) {
            $query->where('location_id', $request->input('location_id'));
        }

        if ($request->filled('genre_id')) {
            $query->where('genre_id', $request->input('genre_id'));
        }

        if ($request->filled('keyword')) {
            $query->where('shop', 'LIKE', '%' . $request->input('keyword') . '%');
        }

        $shops = $query->with(['location', 'genre'])->get();

        $shops->each(function ($shop) {
            $shop->checkIfUserFavorite = $shop->checkIfUserFavorite();
        });

        $locations = Location::all();
        $genres = Genre::all();

        // dd($shops, $locations, $genres);

        return view('shops', compact('shops', 'locations', 'genres', 'request'));
    }

    public function detail($id)
    {
        $shop = Shop::with(['location', 'genre'])->find($id);

        if ($shop) {
            $shop->checkIfUserFavorite = $shop->checkIfUserFavorite();
        }

        $shops = Shop::with(['location', 'genre'])->get();
        $locations = Location::all();
        $genres = Genre::all();
        $reviews = Review::where('shop_id', $id)->get();

        return view('shopsDetail', compact('shop', 'shops', 'locations', 'genres', 'reviews'));
    }
}
