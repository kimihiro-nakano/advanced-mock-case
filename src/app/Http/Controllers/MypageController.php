<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReservationRequest;
use Illuminate\Http\Request;
use App\Models\Shop;
use App\Models\Location;
use App\Models\Genre;
use App\Models\Reservation;
use App\Models\Review;


class MypageController extends Controller
{
    public function index()
    {
        $reservations = Reservation::with(['shop', 'review'])
            ->where('user_id', auth()->id())
            ->get();

        $favoriteShops = Shop::whereHas('favorites', function ($query) {
            $query->where('user_id', auth()->id());
        })->with(['location', 'genre'])->get();

        return view('mypage', compact('reservations', 'favoriteShops'));
    }

    public function edit($id)
    {
        $reservation = Reservation::with('shop')->where('id', $id)->where('user_id', auth()->id())->first();

        $shop = Shop::with(['location', 'genre'])->find($id);
        if ($shop) {
            $shop->checkIfUserFavorite = $shop->checkIfUserFavorite();
        }

        $shops = Shop::with(['location', 'genre'])->get();
        $locations = Location::all();
        $genres = Genre::all();

        return view('editBooking', compact('reservation', 'shop', 'shops', 'locations', 'genres'));
    }

    public function update(Request $request, $id)
    {
        $reservation = Reservation::where('id', $id)->where('user_id', auth()->id())->first();

        // リクエストから新しい時間と人数を取得
        $newTime = $request->input('time');
        $newNumber = (int)$request->input('number'); // 数値で比較するためにキャスト

        // 現在の予約の時刻を適切に比較できる形式にする
        $currentFormattedTime = \Carbon\Carbon::parse($reservation->time)->format('H:i');

        // 時間と人数を確認し、同じ場合はエラーを返す
        if ($currentFormattedTime === $newTime && $reservation->number_of_people === $newNumber) {
            return redirect()->back()->with('error', '時間か人数のいずれかを変更してください。');
        }

        // 更新処理
        $reservation->update([
            'time' => $newTime,
            'number_of_people' => $newNumber,
        ]);

        return redirect()->route('mypage')->with('success', '予約が変更されました');
    }
}
