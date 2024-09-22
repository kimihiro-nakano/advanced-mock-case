@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth/login.css') }}">
@endsection

@section('content')
<div class="login-form__content">
    <div class="wrapper">
        <div class="login-form__heading">
            <p>Login</p>
        </div>
        <form action="{{ route('login') }}" class="form" method="post">
            @csrf
            <div class="form__group">
                <div class="form__group-content">
                    <div class="img">
                        <img src="{{ asset('/img/email.png') }}"/>
                    </div>
                    <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" />
                </div>
                <div class="form__error">
                    @error('email')
                    {{ $message }}
                    @enderror
                </div>
                <div class="form__group-content">
                    <div class="img">
                        <img src="{{ asset('/img/password.png') }}"/>
                    </div>
                    <input type="password" name="password" placeholder="Password" />
                </div>
                <div class="form__error">
                    @error('password')
                    {{ $message }}
                    @enderror
                </div>
                <div class="form__group-content">
                    <div class="img">
                        <img src="{{ asset('/img/category.png') }}"/>
                    </div>
                    <select name="role" id="role" required>
                        <option value="">Category</option>
                        <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>利用者
                        </option>
                        <option value="shop_owner" {{ old('role') == 'shop_owner' ? 'selected' : '' }}>店舗代表者</option>
                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>管理者</option>
                    </select>
            </div>
            <div class="form__button">
                <button class="form__button-submit" type="submit">ログイン</button>
            </div>
        </form>
    </div>
</div>
@endsection
