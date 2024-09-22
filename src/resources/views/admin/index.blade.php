@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endsection

@section('content')
<div class="admin__content">
    <div class="admin__title">
        <h2 class="admin-name">{{ Auth::user()->name }}さん</h2>
    </div>
</div>
@endsection
