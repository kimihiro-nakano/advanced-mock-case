<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rese</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@yield('css')
</head>

<body>
    <header class="header">
        <div class="header__inner">
            <div class="modal__open">
                <a href="#modal" class="modal-button">
                    <div class="logo-icon">
                        <div class="line medium"></div>
                        <div class="line long"></div>
                        <div class="line short"></div>
                    </div>
                    <div class="logo-text">Rese</div>
                </a>
            </div>

            @if (Auth::check())
            @auth
                <div class="modal" id="modal">
                    <a href="#!" class="modal-overlay"></a>
                    <div class="modal__content">
                        <a href="#" class="modal__close"></a>
                        <div class="modal__menu">
                            <a href="/" class="list">Home</a>
                            <form class="form" action="/logout" method="post">
                            @csrf
                                <button class="list">Logout</button>
                            </form>
                            <a href="/mypage" class="list">Mypage</a>
                        </div>
                    </div>
                </div>
            @endauth
            @endif

            @guest
            <div class="modal" id="modal">
                <a href="#!" class="modal-overlay"></a>
                <div class="modal__content">
                    <a href="#" class="modal__close"></a>
                    <div class="modal__menu">
                        <a href="/" class="list">Home</a>
                        <a href="/register" class="list">Registration</a>
                        <a href="/login" class="list">Login</a>
                    </div>
                </div>
            </div>
            @endguest
        @yield('header')
        </div>
    </header>

    <main>
        @yield('content')
    </main>

</body>

</html>
