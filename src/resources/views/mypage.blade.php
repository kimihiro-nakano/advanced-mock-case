@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
@endsection

@section('content')
@if(session('success'))
    <div class="alert__alert-success">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert__alert-danger">
        {{ session('error') }}
    </div>
@endif

<div class="mypage__content">
    <div class="mypage__title">
        <h2 class="user-name">{{ Auth::user()->name }}さん</h2>
    </div>
    <div class="mypage__sections">
        <div class="mypage__reservation">
            <div class="rservation__content">
                <h3>予約状況</h3>

                @php
                $pastCounter = 1;
                $futureCounter = 1;
                @endphp

                @forelse($reservations->sortByDesc('date') as $reservation)
                @php
                $reservationDateTime = \Carbon\Carbon::parse($reservation->date . ' ' . $reservation->time);
                @endphp

                <div class="reservation__list">
                    <div class="reservation__card">
                        <div class="card__container">
                            <div class="clock__img">
                                <img src="{{ asset('/img/time.png') }}"/>
                            </div>

                            <div class="title">
                                @if($reservationDateTime->isFuture())
                                    <!-- 未来の予約内容の表示を先に -->
                                    予約 {{ $futureCounter++ }}
                                @else
                                    <!-- 過去の予約内容の表示を後に -->
                                    行ったお店 {{ $pastCounter++ }}
                                @endif
                            </div>

                            @if($reservationDateTime->isFuture() || $reservationDateTime->isToday())
                                <!-- 未来と当日の予約については削除ボタンを表示 -->
                                <form action="{{ route('reservation.destroy', $reservation) }}" method="post">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="modal__close-btn" onClick="return confirm('この予約を取消してよろしいですか？')">×</button>
                                </form>
                            @endif
                        </div>
                    </div>
                    <table class="reservation__table">
                        <tr class="reservation__row">
                            <td class="reservation__label">Shop</td>
                            <td class="reservation__data">{{ $reservation->shop->shop }}</td>
                        </tr>
                        <tr class="reservation__row">
                            <td class="reservation__label">Date</td>
                            <td class="reservation__data">{{ $reservation->date }}</td>
                        </tr>
                        <tr class="reservation__row">
                            <td class="reservation__label">Time</td>
                            <td class="reservation__data">{{ \Carbon\Carbon::parse($reservation->time)->format('H:i') }}</td>
                        </tr>
                        <tr class="reservation__row">
                            <td class="reservation__label">Number</td>
                            <td class="reservation__data">{{ $reservation->number_of_people }}人</td>
                        </tr>
                    </table>

                    <div class="edit">
                        @if($reservationDateTime->isFuture() && !$reservationDateTime->isToday())
                            <!-- 未来の予約内容の変更を許可 -->
                            <form action="{{ route('editBooking', ['id' => $reservation->id]) }}" method="get">
                                <div class="edit__button">
                                    <button class="edit__button-submit" type="submit">予約内容の変更</button>
                                </div>
                            </form>
                        @elseif($reservationDateTime->isToday())
                            <!-- 当日の予約は変更不可 -->
                            <p class="no__edit">当日の予約は変更できません。</p>
                        @else
                            <!-- 過去の予約に対してレビュー済みかどうかを表示 -->
                            @if(!$reservation->review)
                                <!-- レビューが存在しない場合 -->
                                <form action="{{ route('review', ['reservation_id' => $reservation->id]) }}" method="get">
                                    <div class="review__button">
                                        <button class="review__button-submit" type="submit">レビューを投稿</button>
                                    </div>
                                </form>
                            @else
                                <!-- レビューが存在する場合 -->
                                <p class="reviewed">レビュー済み</p>
                            @endif
                        @endif
                    </div>
                </div>
                @empty
                    <p>現在、レストランの予約はありません。</p>
                @endforelse
            </div>
        </div>

        <div class="favorite__content">
            <h3>お気に入り店舗</h3>
            <div class="favorite__list">
                @forelse($favoriteShops as $shop)
                    <div class="shops__card">
                        <div class="shops__img">
                            <img src="{{ asset($shop->image) }}" alt="{{ $shop->shop }}"/>
                        </div>
                        <div class="card__content">
                            <h2 class="card__title">{{$shop->shop}}</h2>
                            <p class="card__tag">#{{$shop->location->location}} </p>
                            <p class="card__tag">#{{$shop->genre->genre}}</p>
                        </div>
                        <form action="{{route('detail',$shop->id)}}" method="get">
                            @csrf
                            <div class="detail__button">
                                <button class="detail__button-submit" type="submit">詳しく見る</button>
                                <div class="favorite__btn">
                                    <button class="favorite__button {{ $shop->isFavorite ? 'active' : '' }}"
                                        type="button" data-shop-id="{{ $shop->id }}">
                                        <i class="fa fa-heart" aria-hidden="true"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                @empty
                    <p>現在、お気に入りのレストランはありません。</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

<script>
    document.querySelectorAll('.favorite__button').forEach(function(button) {
        button.addEventListener('click', function() {
            var shopId = this.dataset.shopId;
            var isActive = this.classList.contains('active');
            var url = `/shop/${shopId}/favorite`;
            var method = 'DELETE';

            fetch(url, {
                method: method,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
            }).then(response => response.json())
            .then(data => {
                if (data.status === 'removed') {
                    location.reload();
                }
            }).catch(error => {
                console.error('Error:', error);
            });
        });
    });
</script>
@endsection
