@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/shops.css') }}">
@endsection

@section('header')
<div class="search">
    <div class="search__inner">
        <form action="{{ route('search') }}" class="search-form" method="get">
            <div class="search-form__area">
                <select class="search-form__area-select" name="location_id" id="location">
                    <option value="" {{ is_null(request('location_id')) || request('location_id') === '' ? 'selected' : '' }}>All area</option>
                    @foreach ($locations as $location)
                        <option value="{{ $location->id }}" {{ request('location_id') == $location->id ? 'selected' : '' }}>
                            {{ $location->location }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="search-form__genre">
                <select class="search-form__genre-select" name="genre_id" id="genre">
                    <option value="" {{ is_null(request('genre_id')) || request('genre_id') === '' ? 'selected' : '' }}>All genre</option>
                    @foreach ($genres as $genre)
                        <option value="{{ $genre->id }}" {{ request('genre_id') == $genre->id ? 'selected' : '' }}>
                            {{ $genre->genre }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="search-form__keyword">
                <button class="search-btn" type="submit">
                    <i class="fas fa-search search-form__icon"></i>
                </button>
                <input name="keyword" type="text" class="search-form__keyword-input" placeholder="Search .." value="{{ old('keyword', request('keyword')) }}">
            </div>
            <div class="search-form__reset">
                <a href="{{ route('search') }}" class="reset-btn">
                    <i class="fas fa-times reset-icon"></i>
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

@section('content')
<div id="error-message" class="error-message"></div>
<div class="wrapper">
    @foreach($shops as $shop)
    <div class="shops__card">
        <div class="shops__img">
            <img src="{{ asset($shop->image) }}" alt="{{ $shop->shop }}"/>
        </div>
        <div class="card__content">
            <h2 class="card__title">{{$shop->shop}}</h2>
            <p class="card__tag">#{{$shop->location->location}}</p>
            <p class="card__tag">#{{$shop->genre->genre}}</p>
        </div>
        <form action="{{route('detail',$shop->id)}}" method="get">
            @csrf
            <div class="detail__button">
                <button class="detail__button-submit" type="submit">詳しく見る</button>
                <div class="favorite">
                    <button class="favorite__button {{ $shop->checkIfUserFavorite ? 'active' : '' }}" type="button" data-shop-id="{{ $shop->id }}">
                        <i class="fa fa-heart" aria-hidden="true"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>
    @endforeach
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var resetButton = document.querySelector('.reset-btn');
    var inputs = document.querySelectorAll('.search-form input[type="text"], .search-form select');

    function checkInputFilled() {
        let hasInput = false;
        inputs.forEach(function(input) {
            if (input.value.trim() !== '') {
                hasInput = true;
            }
        });
        resetButton.style.display = hasInput ? 'inline-flex' : 'none';
    }

    inputs.forEach(function(input) {
        input.addEventListener('input', checkInputFilled);
        input.addEventListener('change', checkInputFilled);
    });

    resetButton.addEventListener('click', function() {
        inputs.forEach(function(input) {
            if (input.tagName.toLowerCase() === 'select') {
                input.selectedIndex = 0;
            } else {
                input.value = '';
            }
        });
        resetButton.style.display = 'none';
    });

    checkInputFilled();

    document.querySelectorAll('.favorite__button').forEach(function(button) {
        button.addEventListener('click', function() {
            var shopId = this.dataset.shopId;
            var isActive = this.classList.contains('active');
            var url = `/shop/${shopId}/favorite`;
            var method = isActive ? 'DELETE' : 'POST';

            var errorMessage = document.getElementById('error-message');
            errorMessage.style.display = 'none';

            fetch(url, {
                method: method,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
            })
            .then(response => {
                if (response.status === 401) {
                    errorMessage.textContent = 'ログインが必要です。';
                    errorMessage.style.display = 'block';
                    return null;
                }
                return response.json();
            })
            .then(data => {
                if (data) {
                    if (data.status === 'added') {
                        this.classList.add('active');
                    } else if (data.status === 'removed') {
                        this.classList.remove('active');
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
    });
});
</script>
@endsection
