<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ReviewRequest;
use App\Models\Reservation;
use App\Models\Review;
use App\Models\Shop;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function index($reservation_id)
    {
        $userId = Auth::id();

        // 予約情報の取得
        $reservation = Reservation::where('id', $reservation_id)
            ->where('user_id', $userId)
            ->first();

        if (!$reservation) {
            return redirect()->back()->with('error', '予約が見つかりませんでした。');
        }

        $shop = $reservation->shop;

        // この予約に対する既存のレビューを取得
        $review = $reservation->review;

        // ここで $reservation_id をビューに渡す
        return view('review', compact('shop', 'review', 'reservation', 'reservation_id'));
    }

    public function store(ReviewRequest $request, $reservation_id)
    {
        $userId = Auth::id();

        // 予約情報の取得と確認
        $reservation = Reservation::where('id', $reservation_id)
            ->where('user_id', $userId)
            ->first();

        if (!$reservation) {
            return redirect()->back()->with('error', '予約が見つかりませんでした。');
        }

        $shop = $reservation->shop;

        // この予約に対する既存のレビューを取得
        $review = $reservation->review;

        if ($review) {
            // レビューの更新
            $review->update($request->validated());
        } else {
            // 新規レビューの作成
            $review = new Review();
            $review->user_id = $userId;
            $review->shop_id = $shop->id;
            $review->reservation_id = $reservation_id;
            $review->stars = $request->input('stars');
            $review->comment = $request->input('comment');
            $review->save();
        }

        return redirect()->route('reviewThanks', ['shop_id' => $shop->id]);
    }

    public function complete($shop_id)
    {
        $shop = Shop::find($shop_id);

        return view('reviewThanks', compact('shop'));
    }

    public function destroy($review_id)
    {
        $review = Review::find($review_id);

        if (!$review) {
            return redirect()->back()->with('error', 'レビューが見つかりませんでした。');
        }

        // ログイン中のユーザーがこのレビューの投稿者か確認
        if ($review->reservation->user_id !== auth()->id()) {
            return redirect()->back()->with('error', 'このレビューを削除する権限がありません。');
        }

        $review->delete();

        return redirect()->route('mypage')->with('success', 'レビューを削除しました。');
    }
}
