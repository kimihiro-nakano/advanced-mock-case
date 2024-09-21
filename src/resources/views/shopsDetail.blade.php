@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/shops-detail.css') }}">
@endsection

@section('content')
<div class="shop__detail">
    <div class="detail__sections">
        <div class="return__btn">
            <a href="/" class="return__button"><</a>
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
        <form action="{{ route('reservations.store', ['shop_id' => $shop->id]) }}" method="post">
            @csrf
            <div class="reservation">
                <h3 class="reservation-title">予約</h3>
                    <div class="reservation__date">
                        <input type="date" name="date" class="reservation-date" id="reservation-date" value='{{old('date') }}'></input>
                        @error('date')
                            <div class="error__message">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="reservation__time">
                        <select name="time" class="reservation-time" id="reservation-time">
                            <option value='{{old('time') }}'>時間を指定してください</option>
                        </select>
                        @error('time')
                            <div class="error__message">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="reservation__number">
                        <select name="number" class="reservation-number" id="reservation-number">
                            <option value="">人数を指定してください</option>
                            @for ($i = 1; $i <=20; $i++)
                                <option value="{{ $i }}" {{ old('number') == $i ? 'selected' : '' }}>{{ $i }}人</option>
                            @endfor
                        </select>
                        @error('number')
                            <div class="error__message">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="reservation__list">
                        <table class="reservation__table">
                            <tr class="reservation__row">
                                <td class="reservation__label">Shop</td>
                                <td class="reservation__data">{{ $shop->shop }}</td>
                            </tr>
                            <tr class="reservation__row">
                                <td class="reservation__label">Date</td>
                                <td class="reservation__data"><span id="selected-date">日付を指定してください</span></td>
                            </tr>
                            <tr class="reservation__row">
                                <td class="reservation__label">Time</td>
                                <td class="reservation__data"><span id="selected-time">時間を指定してください</span></td>
                            </tr>
                            <tr class="reservation__row">
                                <td class="reservation__label">Number</td>
                                <td class="reservation__data"><span id="selected-number">人数を指定してください</span></td>
                            </tr>
                        </table>
                    </div>
                    <h3 class="review-title">レビュー</h3>
                    <div class="review">
                        @forelse($reviews as $review)
                            <div class="review__list">
                                <div class="review__item">
                                    <div class="reservation__label">User</div>
                                    <div class="review__data">{{ $review->user->name }}さん</div>
                                </div>
                                <div class="review__item">
                                    <div class="reservation__label">Date</div>
                                    <div class="review__data">{{ $review->reservation->date }}</div>
                                </div>
                                <div class="review__item">
                                    <div class="reservation__label">rating</div>
                                    <div class="review__data">
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($i <= $review->stars)
                                                <i class="fas fa-star" style="color: #ffd700;"></i>
                                            @else
                                                <i class="far fa-star" style="color: #ffd700;"></i>
                                            @endif
                                        @endfor
                                    </div>
                                </div>
                                <div class="review__item">
                                    <div class="reservation__label">Comment</div>
                                    <div class="review__data">
                                        @if (mb_strlen($review->comment) > 20)
                                            <div class="comment-preview">
                                                {{ \Illuminate\Support\Str::limit($review->comment, 20, '...') }}
                                            </div>
                                            <div class="full-comment">
                                                {{ $review->comment }}
                                            </div>
                                        @else
                                            <div class="full-comment no-toggle">
                                                {{ $review->comment }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="review__list">
                                <p class="no__review">現在、レストランのレビューはありません。</p>
                            </div>
                        @endforelse
                    </div>
                    <div class="reservation__button">
                        @if (Auth::check())
                            <button class="reservation__button-submit" type="submit">予約する</button>
                        @else
                            <p class="reservation__message">予約するにはログインが必要です。</p>
                        @endif
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    var oldTime = '{{ old('time') }}';
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // 現在の日付を取得
        var today = new Date();
        var year = today.getFullYear();
        var month = ('0' + (today.getMonth() + 1)).slice(-2); // 月を2桁に
        var day = ('0' + today.getDate()).slice(-2); // 日を2桁に
        var dateString = year + '-' + month + '-' + day;

        // inputのmin属性に設定
        document.getElementById('reservation-date').setAttribute('min', dateString);



function updateAvailableTimes() {
    var timeSelect = document.getElementById('reservation-time');
    // 既存の選択肢をクリア
    timeSelect.innerHTML = '';

    // デフォルトのオプションを追加
    var defaultOption = document.createElement('option');
    defaultOption.value = '';
    defaultOption.textContent = '時間を指定してください';
    defaultOption.selected = true; // デフォルトで選択されるように設定
    timeSelect.appendChild(defaultOption);

    // 営業時間の範囲
    var openingHour = 11;
    var closingHour = 21;

    // 選択された日付を取得
    var selectedDate = document.getElementById('reservation-date').value;
    if (!selectedDate) {
        // 日付が選択されていない場合、デフォルトのオプションだけを表示
        timeSelect.innerHTML = '';
        var option = document.createElement('option');
        option.value = '';
        option.textContent = '日付を選択してください';
        option.selected = true; // デフォルトで選択されるように設定
        timeSelect.appendChild(option);
        return;
    }

    // 現在の日時を取得
    var now = new Date();

    // 時間を30分刻みで生成
    for (var hour = openingHour; hour <= closingHour; hour++) {
        for (var minute = 0; minute < 60; minute += 30) {
            var timeString = ('0' + hour).slice(-2) + ':' + ('0' + minute).slice(-2);
            var optionTime = new Date(selectedDate + 'T' + timeString);

            // 今日の予約の場合、過去の時間を除外
            if (selectedDate === now.toISOString().split('T')[0]) {
                if (optionTime.getTime() <= now.getTime()) {
                    continue;
                }
            }

            var option = document.createElement('option');
            option.value = timeString;
            option.textContent = timeString;
            timeSelect.appendChild(option);
        }
    }

    // 時間の選択肢が更新された後、予約リストを更新
    document.getElementById('selected-time').textContent = timeSelect.value || '時間を指定してください';
}



        // 日付が変更されたときに利用可能な時間を更新
        document.getElementById('reservation-date').addEventListener('change', updateAvailableTimes);

        // ページ読み込み時に時間を更新
        if (document.getElementById('reservation-date').value) {
            updateAvailableTimes();
        }

        // 予約リストの初期表示を更新
        document.getElementById('selected-date').textContent = document.getElementById('reservation-date').value || '日付を指定してください';
        document.getElementById('selected-time').textContent = document.getElementById('reservation-time').value || '時間を指定してください';
        document.getElementById('selected-number').textContent = document.getElementById('reservation-number').value ? document.getElementById('reservation-number').value + "人" : '人数を指定してください';

        // 時間が変更されたときに予約リストを更新
        document.getElementById('reservation-time').addEventListener('change', function() {
            document.getElementById('selected-time').textContent = this.value || '時間を指定してください';
        });

        // 人数が変更されたときに予約リストを更新
        document.getElementById('reservation-number').addEventListener('change', function() {
            document.getElementById('selected-number').textContent = this.value ? this.value + "人" : '人数を指定してください';
        });

        // コメントのプレビューをクリックしたときに詳細を表示
        var commentPreviews = document.querySelectorAll('.comment-preview');

        commentPreviews.forEach(function(preview) {
            var fullComment = preview.nextElementSibling;
            if (fullComment && !fullComment.classList.contains('no-toggle')) {
                preview.addEventListener('click', function() {
                    fullComment.classList.toggle('show');
                });
            }
        });
    });
</script>
@endsection
