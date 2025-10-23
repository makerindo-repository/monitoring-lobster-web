@php
    $menus = [
        [
            'slug' => 'Dashboard',
            'icon' => asset('svg/icon-menu/dashboard.svg'),
            'dropdown' => false,
            'route' => url('/dashboard')
        ],
        [
            'slug' => 'Monitoring',
            'icon' => asset('svg/icon-menu/monitor.svg'),
            'dropdown' => false,
            'route' => url('/monitoring')
        ],
        [
            'slug' => 'Data Master',
            'icon' => asset('svg/icon-menu/data-master.svg'),
            'dropdown' => true,
            'route' => '',
            'dropdown_menu' => [
                [
                    'slug' => 'Edge Computing',
                    'route' => route('edge-computing.index')
                ],
                [
                    'slug' => 'IOT Node',
                    'route' => route('iot-node.index')
                ],
                [
                    'slug' => 'Provinsi',
                    'route' => route('region.index')
                ],
                [
                    'slug' => 'Kota & Kabupaten',
                    'route' => route('city.index')
                ],
            ]
        ],
        [
            'slug' => 'User',
            'icon' => asset('svg/icon-menu/pengguna.svg'),
            'dropdown' => false,
            'route' => route('user.index')
        ],
        [
            'slug' => 'Laporan',
            'icon' => asset('svg/icon-menu/laporan.svg'),
            'dropdown' => false,
            'route' => url('/dashboard')
        ],
    ];
@endphp
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;700;800&display=swap" rel="stylesheet">

    {{-- Styles --}}
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    @stack('header')
    @stack('style')
</head>
<body>
    <div id="app">
         <!-- Topbar -->
         <div id="topbar">
            <nav class="navbar navbar-expand-lg navbar-light bg-white">
                <div class="container-fluid">
                    <div class="navbar-brand">
                        @yield('title')
                    </div>
                    <div id="time" class="d-flex">
                        
                    </div>
                </div>
            </nav>
        </div>
        <!-- End Topbar -->

        <!-- Content -->
        <main class="my-1">
            @yield('content')
        </main>
    </div>

    {{-- Script in app --}}
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script>
        _base_url = "{{ url('/') }}";
        const month = {
            0: "Januari",
            1: "Februari",
            2: "Maret",
            3: "April",
            4: "Mei",
            5: "Juni",
            6: "Juli",
            7: "Agustus",
            8: "September",
            9: "Oktober",
            10: "November",
            11: "Desember"
        };
        setInterval(()=> {
            let date       = new Date();
            let formatDate = `${date.getDate()} ${month[date.getMonth()]} ${date.getFullYear()}; ${date.getHours()}:${date.getMinutes()}:${date.getSeconds()} WIB`; 
            document.getElementById('time')
                    .innerText = formatDate;
        }, 1000);
    </script>
    @stack('footer')
    @stack('script')
</body>
</html>
