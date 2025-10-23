@php
    use Carbon\Carbon;

    $now = now();
    $night_mode = false;

    $start = Carbon::createFromTimeString('18:00');
    $end = Carbon::createFromTimeString('23:59');

    if ($now->between($start, $end)) {
        $night_mode = true;
    }
@endphp
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="icon" href="{{asset('images/unpad-logo.png')}}">


    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;700;800&display=swap" rel="stylesheet">

    {{-- Style --}}
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        * {
            color: #000;
        }

        body {
            height: 100vh;
            background: linear-gradient(0deg, #000000 0%, #373B8E 100%);
            background-size: cover;
            background-position: 100% 100%;
            background-repeat: repeat;
            background-attachment: fixed;
        }


        form input[type=email],
        input[type=password],
        input[type=checkbox] {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            box-shadow: 5px 5px 30px rgba(0, 0, 0, 0.2);
        }

        form label:not(.form-check-label) {
            font-size: 14px;
            font-weight: 700 !important;
        }

        form label.form-check-label {
            font-size: 13px;
            vertical-align: text-bottom;
        }

        form input:not(.form-check-input) {
            font-size: 14px !important;
            border-radius: 0.35rem !important;
        }

        form input[type="email"]:focus,
        form input[type="password"]:focus {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            box-shadow: none;
            border-color: #aaa !important;
            outline: 0;
        }

        form input::placeholder {
            /* Chrome, Firefox, Opera, Safari 10.1+ */
            color: black !important;
            opacity: 1;
            /* Firefox */
        }

        form input:-ms-input-placeholder {
            /* Internet Explorer 10-11 */
            color: black !important;
        }

        form input::-ms-input-placeholder {
            /* Microsoft Edge */
            color: black !important;
        }

        form button {
            font-size: 15px !important;
            border-radius: 0.40rem !important;
        }

        .card {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 16px;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(5px);
            -webkit-backdrop-filter: blur(5px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        img.icon {
            width: 20px;
            vertical-align: text-bottom;
            margin-right: 2px;
        }

        .copyright {
            position: absolute;
            left: 50%;
            bottom: 20px;
            transform: translateX(-50%);
        }
        .copyright h6,
        .copyright b {
            color: #ebe4e4;
            font-size: 14px;
        }
        @media (max-width: 767px) {
        .copyright {
        position: relative;
        left: 50%;
        bottom: -100px;
        transform: translateX(-50%);
        width: 100%;
        padding: 20px 0;
        text-align: center;
        font-size: 12px;
        }
        }

        @media (min-width: 768px) {
            .col-md-4 {
                width: 37.33333333% !important;
            }
        }
    </style>
</head>

<body>
    <div id="app">
        <main class="mt-5">
            @yield('content')
        </main>
    </div>

    @stack('script')
    @stack('footer')
</body>

</html>
