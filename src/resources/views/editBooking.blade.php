
@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/editBooking.css') }}">
@endsection

@section('content')

@if(session('error'))
    <div class="alert__alert-danger">
        {{ session('error') }}
    </div>
@endif

<div class="shop__detail">
    <div class="detail__sections">
        <div class="return__btn">
            <a href="/mypage" class="return__button"><</a>
            <h2 class="shop">{{$shop->shop}}</h2>
        </div>
        <div class="shops__img">
            <img src="{{ asset($shop->image) }}" alt="{{ $shop->shop }}"/>
        </div>
        <div class="shop__cantent">
            <p class="card__tag">#{{$shop->location->location}} #{{$shop->genre->genre}}</p>
            <p class="shop__summary">{{$shop->overview}}</p>
        </div>
    </div>

    <div class="shop__reservation">
        <form action="{{ route('updateBooking', ['id' => $reservation->id]) }}" method="post">
            @csrf
            <div class="reservation">
                <h3 class="reservation-title">予約内容の変更</h3>
                    <div class="reservation__list">
                        <table class="reservation__table">
                            <tr class="reservation__row">
                                <td class="reservation__label">Shop</td>
                                <td class="reservation__data">{{ $shop->shop }}</td>
                            </tr>
                            <tr class="reservation__row">
                                <td class="reservation__label">Date</td>
                                <td class="reservation__data">{{ $reservation->date }}</td>
                            </tr>
                            <tr class="reservation__row">
                                <td class="reservation__label">Time</td>
                                <td class="reservation__data">
                                    <select name="time" class="reservation-time" id="reservation-time">
                                        <option value="">時間を指定してください</option>
                                        @for ($hour = 11; $hour <= 21; $hour++)
                                            @for ($min = 0; $min < 60; $min += 30)
                                                @if ($hour === 21 && $min > 0) @break @endif
                                                @php
                                                    $timeString = sprintf('%02d:%02d', $hour, $min);
                                                @endphp
                                                <option value="{{ $timeString }}" {{ old('time', \Carbon\Carbon::parse($reservation->time)->format('H:i')) == $timeString ? 'selected' : '' }}>
                                                    {{ $timeString }}
                                                </option>
                                            @endfor
                                        @endfor
                                        @error('time')
                                            <div class="error">{{ $message }}</div>
                                        @enderror
                                    </select>
                                </td>
                            </tr>
                            <tr class="reservation__row">
                                <td class="reservation__label">Number</td>
                                <td class="reservation__data">
                                    <select name="number" class="reservation-number" id="reservation-number">
                                        <option value=""></option>
                                        @for ($i = 1; $i <= 20; $i++)
                                            <option value="{{ $i }}" {{ old('number', $reservation->number_of_people) == $i ? 'selected' : '' }}>
                                                {{ $i }}人
                                            </option>
                                        @endfor
                                        @error('number')
                                            <div class="error">{{ $message }}</div>
                                        @enderror
                                    </select>
                                </td>
                            </tr>
                        </table>
                    </div>
                <div class="reservation__button">
                    <button class="reservation__button-submit" type="submit">この内容で予約を変更する</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // 初期化時に選択された日付と時間を表示
    document.getElementById('selected-time').textContent = document.getElementById('reservation-time').value || '時間を指定してください';
    document.getElementById('selected-number').textContent = document.getElementById('reservation-number').value ? document.getElementById('reservation-number').value + "人" : '人数を指定してください';

    // 予約リストで選択された時間を表示するためのイベントハンドラ
    document.getElementById('reservation-time').addEventListener('change', function() {
        document.getElementById('selected-time').textContent = this.value || '時間を指定してください';
    });

    document.getElementById('reservation-number').addEventListener('change', function() {
        document.getElementById('selected-number').textContent = this.value ? this.value + "人" : '人数を指定してください';
    });
});
</script>
@endsection
