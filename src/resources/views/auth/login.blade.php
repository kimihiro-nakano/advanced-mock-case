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
            </div>
            {{-- <div class="form__group-content">
                <div class="form__input-text">
                    <input type="password" name="password_confirmation" placeholder="ConfirmPassword" />
                </div>
            </div> --}}
            <div class="form__button">
                <button class="form__button-submit" type="submit">ログイン</button>
            </div>
        </form>
    </div>
</div>
@endsection
