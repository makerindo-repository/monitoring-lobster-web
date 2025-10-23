@php
    $logo_app = get_app_info('logo');
    $menus = [
        [
            'slug' => 'Dashboard',
            'icon' => asset('svg/icon-menu/dashboard.svg'),
            'dropdown' => false,
            'route' => url('/dashboard'),
        ],
        [
            'slug' => 'Monitoring',
            'icon' => asset('svg/icon-menu/monitor.svg'),
            'dropdown' => false,
            'route' => url('/monitoring'),
        ],
        [
            'slug' => 'Data Master',
            'icon' => asset('svg/icon-menu/data-master.svg'),
            'dropdown' => true,
            'route' => '',
            'dropdown_menu' => [
                [
                    'slug' => 'Edge Computing',
                    'route' => route('edge-computing.index'),
                ],
                [
                    'slug' => 'IOT Node',
                    'route' => route('iot-node.index'),
                ],
                [
                    'slug' => 'Provinsi',
                    'route' => route('region.index'),
                ],
                [
                    'slug' => 'Kota & Kabupaten',
                    'route' => route('city.index'),
                ],
                [
                    'slug' => 'Client',
                    'route' => route('client.index'),
                ],
                [
                    'slug' => 'Sensor',
                    'route' => route('sensor.index'),
                ],
            ],
        ],
        [
            'slug' => 'Manajemen Akun',
            'icon' => asset('svg/icon-menu/pengguna.svg'),
            'dropdown' => false,
            'route' => route('user.index'),
        ],
        [
            'slug' => 'Laporan',
            'icon' => asset('svg/icon-menu/laporan.svg'),
            'dropdown' => true,
            'route' => '',
            'dropdown_menu' => [
                [
                    'slug' => 'Registrasi IoT Node',
                    'route' => route('report.nodeRegistration'),
                ],
                [
                    'slug' => 'Data Raw Monitoring',
                    'route' => route('report.rawMonitoring'),
                ],
                [
                    'slug' => 'Riwayat Maintenance',
                    'route' => route('report.maintenanceLog'),
                ],
                [
                    'slug' => 'Log Aktivitas',
                    'route' => route('report.activityLog'),
                ],
            ],
        ],
        [
            'slug' => 'Pengaturan',
            'icon' => asset('svg/icon-menu/pengaturan.svg'),
            'dropdown' => false,
            'route' => url('/setting'),
        ],
    ];
@endphp
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'WQMCS') }}</title>
    <link rel="icon" href="{{ asset('images/unpad-logo.png') }}">


    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;700;800&display=swap" rel="stylesheet">

    {{-- Styles --}}
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <style>
        .btn img {
            border-radius: 50%;
        }

        .navbar .dropdown-toggle::after {
            border-top-color: white !important;
        }
    </style>
    @stack('header')
    @stack('style')
</head>

<body>
    <div id="app">
        <!-- Topbar -->
        <div id="topbar">
            <nav class="navbar-profile py-2">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 d-flex justify-content-between navbar-profile-wrapper">
                            <span class="app-title d-inline-block pt-2">
                                @if ($logo_app)
                                    <img src="{{ asset($logo_app) }}" alt="Logo" width="35px">
                                @endif
                                <b>{{ get_app_info('name') }}</b>
                            </span>
                            <div>
                                <div class="dropdown d-inline-block">
                                    <button class="btn btn-profile dropdown-toggle p-0 ps-1" type="button"
                                        id="profileButton" data-bs-toggle="dropdown" aria-expanded="false">
                                        <img src="{{ url('images/user', auth()->user()->picture) }}" alt=""
                                            height="35" width="35">
                                    </button>
                                    <ul class="dropdown-menu shadow" aria-labelledby="profileButton">
                                        <li class="info border-bottom">
                                            <h6 class="mb-0">{{ auth()->user()->name }}</h6>
                                            <p class="text-gray mb-1" style="font-size:.9em;">
                                                {{ auth()->user()->email }}</p>
                                        </li>
                                        <li class="mt-2"><a class="dropdown-item"
                                                href="{{ route('profile') }}">Pengaturan Akun</a></li>
                                        <li><a class="dropdown-item" href="#" onclick="Logout();">Logout</a>
                                        </li>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                            @csrf
                                        </form>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
            <nav class="navbar navbar-expand-lg navbar-light" style="background-color: #FB9E3A;">
                <div class="container">
                    <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarMenu"
                        aria-controls="navbarMenu" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarMenu">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            @foreach ($menus as $index => $menu)
                                @if ($menu['dropdown'])
                                    <li class="nav-item dropdown me-4">
                                        <a class="nav-link dropdown-toggle" href="#"
                                            id="navbarDropdown{{ $index }}" role="button"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            <img src="{{ $menu['icon'] }}" alt="ic"
                                                style="filter: brightness(0) invert(1);">
                                            <span class="text-white">{{ $menu['slug'] }}</span>
                                        </a>
                                        <ul class="dropdown-menu shadow"
                                            aria-labelledby="navbarDropdown{{ $index }}">
                                            @foreach ($menu['dropdown_menu'] as $dropdown_menu)
                                                <li><a class="dropdown-item"
                                                        href="{{ $dropdown_menu['route'] }}">{{ $dropdown_menu['slug'] }}</a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </li>
                                @else
                                    <li class="nav-item me-4">
                                        <a href="{{ $menu['route'] }}" class="nav-link">
                                            <img src="{{ $menu['icon'] }}" alt="ic"
                                                style="filter: brightness(0) invert(1);">
                                            <span class="text-white">{{ $menu['slug'] }}</span>
                                        </a>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
        <!-- End Topbar -->


        <!-- Content -->
        <main>
            @yield('content')
            <br><br>
        </main>
    </div>

    {{-- Script in app --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script>
        _base_url = "{{ url('/') }}";
    </script>
    @stack('footer')
    <footer>
        <div class="bottom">Copyright © 2023 {{ get_app_info('copyright') }} - All rights reserved</div>
    </footer>
    @stack('script')
    <script src="{{ asset('js/disabledSubmitButton.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function deleteActivity(id) {
            event.preventDefault();

            const formId = `Hapus${id}`;
            const form = document.getElementById(formId);

            Swal.fire({
                title: 'Apakah Anda Yakin Ingin Menghapus?',
                text: 'Data Akan Terhapus!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#28a746',
                cancelButtonColor: '#FF0000',
                confirmButtonText: 'Hapus',
                cancelButtonText: 'Batal',
                reverseButtons: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        }
    </script>
    <script>
        function Logout() {
            event.preventDefault();
            const Logout = document.getElementById('logout-form');

            Swal.fire({
                title: 'Apakah Anda Yakin?',
                text: "Anda akan keluar dari akun ini!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Keluar',
                cancelButtonText: 'Batal',
                reverseButtons: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#logout-form').submit();
                }
            });

        }
    </script>
</body>

</html>
