@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth/register.css') }}">
@endsection

@section('content')
<div class="register-form__content">
    <div class="wrapper">
        <div class="register-form__heading">
            <p>Registration</p>
        </div>
        <form action="{{ route('register') }}" class="form" method="post">
            @csrf
            <div class="form__group">
                <div class="form__group-content">
                    <div class="img">
                        <img src="{{ asset('/img/user.png') }}"/>
                    </div>
                    <input type="text" name="name" placeholder="Username" value="{{ old('name') }}" />
                </div>
                <div class="form__error">
                    @error('name')
                    {{ $message }}
                    @enderror
                </div>
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
                {{-- <div class="form__group-content">
                    <div class="form__input-text"></div>
                    <input type="password" name="password_confirmation" placeholder="ConfirmPassword" />
                </div> --}}
                {{-- <div class="form__error">
                    @error('password')
                    {{ $message }}
                    @enderror
                </div> --}}
            </div>
            <div class="form__button">
                <button class="form__button-submit" type="submit">登録</button>
            </div>
        </form>
    </div>
</div>
@endsection
