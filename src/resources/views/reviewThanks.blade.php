@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/complete.css') }}">
@endsection

@section('content')
<div class="complete__content">
    <div class="wrapper">
        <div class="complete__heading">
            <p>レビューの投稿ありがとうございます</p>
        </div>
        <div class="return__button">
            <a href="/mypage" class="return__button-submit">戻る</a>
        </div>
    </div>
</div>
@endsection
