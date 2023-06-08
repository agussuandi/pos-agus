<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('dist/css/bootstrap.min.css') }}">
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="javascript:void(0)">POS Agus</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarScroll">
                <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px;">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="{{ route('sales-order.index') }}">Cashier</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('history.index') }}">History</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container my-5">
        @include('layouts.message-flash')
        @yield('content')
    </div>
    <script src="{{ asset('dist/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('dist/js/moment.js') }}"></script>
    <script src="{{ asset('dist/js/pos.js') }}"></script>
    @yield('javascript')
</body>
</html>
