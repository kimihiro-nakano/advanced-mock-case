@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/owner.css') }}">
@endsection

@section('content')
<div class="owner__content">
    <div class="owner__title">
        <h2 class="owner-name">{{ Auth::user()->name }}さん</h2>
    </div>
</div>
@endsection
