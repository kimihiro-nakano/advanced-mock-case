
    @extends('layouts.app')

    @section('css')
    <link rel="stylesheet" href="{{ asset('css/review.css') }}">
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
                <h2 class="shop">{{ $shop->shop }}</h2>
            </div>
            <div class="shops__img">
                <img src="{{ asset($shop->image) }}" alt="{{ $shop->shop }}"/>
            </div>
            <div class="shop__content">
                <p class="card__tag">#{{ $shop->location->location }} #{{ $shop->genre->genre }}</p>
                <p class="shop__summary">{{ $shop->overview }}</p>
            </div>
        </div>

        <div class="shop__review">
            <form action="{{ route('review.store', ['reservation_id' => $reservation->id]) }}" method="post">
                @csrf
                <input type="hidden" name="reservation_id" value="{{ $reservation_id }}">

                <div class="review">
                    <h3 class="review-title">レビューの内容</h3>
                    <div class="review__list">
                        <div class="review__table">
                            <div class="review__row">
                                <p class="rating__title">評価</p>
                                @error('stars')
                                    <span class="error__message">{{ $message }}</span>
                                @enderror
                                <div class="rating__data">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <input type="radio" name="stars" id="star{{ $i }}" value="{{ $i }}" class="rating__star" {{ (old('stars', $review->stars ?? '') == $i) ? 'checked' : '' }}>
                                    <label for="star{{ $i }}" class="rating__star-label">★</label>
                                    @endfor
                                </div>
                            </div>
                            <div class="review__row">
                                <p class="review__title">あなたの感想を聞かせてください</p>
                                @error('comment')
                                    <p class="error__message">{{ $message }}</p>
                                @enderror
                                <textarea class="review__form-textarea" id="text-input" name="comment" placeholder="口コミ本文を入れてください（400文字以下）">{{ old('comment', $review->comment ?? '') }}</textarea>
                                <p class="count-string" id="text-count">入力文字数： 0</p>
                            </div>
                        </div>
                    </div>
                    <div class="review__button">
                        <button class="review__button-submit" type="submit">レビューする</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('text-input').addEventListener('input', function() {
            var text = this.value;
            var textCountElement = document.getElementById('text-count');
            textCountElement.textContent = "入力文字数： " + text.length;

            // 文字数が400を超えた場合は赤字にする
            if (text.length > 400) {
                textCountElement.style.color = 'red';
            } else {
                textCountElement.style.color = 'black';
            }
        });

        // 星の評価に関するスクリプト
        const stars = document.querySelectorAll('.rating__star');
        const labels = document.querySelectorAll('.rating__star-label');

        stars.forEach((star, index) => {
            star.addEventListener('change', () => {
                updateStarColors(index);
            });

            labels[index].addEventListener('mouseover', () => {
                highlightStars(index);
            });

            labels[index].addEventListener('mouseout', () => {
                resetStarColors();
            });
        });

        function updateStarColors(selectedIndex) {
            labels.forEach((label, i) => {
                label.style.color = i <= selectedIndex ? '#ffd700' : '#ffffff';
            });
        }

        function highlightStars(hoverIndex) {
            labels.forEach((label, i) => {
                label.style.color = i <= hoverIndex ? '#ffd700' : '#ffffff';
            });
        }

        function resetStarColors() {
            stars.forEach((star, index) => {
                if (star.checked) {
                    updateStarColors(index);
                } else {
                    labels[index].style.color = '#ffffff';
                }
            });
        }

        // ページ読み込み時に星の色を設定
        window.addEventListener('load', () => {
            resetStarColors();
        });
    </script>

    @endsection

