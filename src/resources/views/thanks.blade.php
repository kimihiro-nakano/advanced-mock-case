@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/thanks.css') }}">
@endsection

@section('content')
<div class="thanks__content">
    <div class="wrapper">
        <div class="thanks__heading">
            <p>会員登録ありがとうございます</p>
        </div>
        <div class="login__button">
            <a href='/login' class="login__button-submit">ログインする</a>
        </div>
    </div>
</div>
@endsection
