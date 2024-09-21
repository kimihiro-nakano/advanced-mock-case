<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ReservationRequest;
use App\Models\Shop;
use App\Models\Location;
use App\Models\Genre;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ReservationController extends Controller
{
    public function store(ReservationRequest $request, $id)
    {
        $reservation = new Reservation();
        $reservation->user_id = auth()->id();
        $reservation->shop_id = $id;
        $reservation->date = $request->input('date');
        $reservation->time = $request->input('time');
        $reservation->number_of_people = $request->input('number');
        $reservation->save();

        return redirect()->route('complete');
    }

    public function complete()
    {
        return view('complete');
    }

    public function destroy(Reservation $reservation)
    {
        // 予約日時を取得
        $reservationDateTime = Carbon::parse($reservation->date . ' ' . $reservation->time);

        // 過去の予約は削除できないようにする
        if ($reservationDateTime->isPast() && !$reservationDateTime->isToday()) {
            return redirect()->route('mypage')->with('error', '過去の予約は削除できません。');
        }

        // 予約を削除
        $reservation->delete();

        return redirect()->route('mypage')->with('success', '予約を削除しました。');
    }
}
