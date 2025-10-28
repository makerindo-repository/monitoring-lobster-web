@extends('pages.layouts.app')

@push('header')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
        integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
        crossorigin="" />
@endpush

@push('style')
    <style>
        #map {
            height: 350px;
        }
    </style>
@endpush

@section('content')
    <div class="container mb-5">
        <h4 class="fw-bold mb-4">Detail Edge Computing</h4>
        <div class="card p-3">
            <div class="row">
                <div class="col-md-4">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card border-0">
                                <div class="card-body">
                                    <div class="picture-wrapper">
                                        <img src="{{ asset($data->picture ?? 'images/default_404.png') }}" alt="picture"
                                            class="picture" width="100%">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card border-0">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p class="m-0 text-secondary">Nomor Serial</p>
                                            <p class="fw-bold">{{ $data->serial_number }}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <p class="m-0 text-secondary">Memory</p>
                                            <p class="fw-bold">{{ $data->memory }}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <p class="m-0 text-secondary">Total IoT Node</p>
                                            <p class="fw-bold">{{ $data->iot_nodes->count() }}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <p class="m-0 text-secondary">Maksimal IoT Node</p>
                                            <p class="fw-bold">{{ $data->maximum_iot }}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <p class="m-0 text-secondary">Processor Clock Speed</p>
                                            <p class="fw-bold">{{ $data->processor_clock_speed }}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <p class="m-0 text-secondary">Nama OS</p>
                                            <p class="fw-bold">{{ $data->os }}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <p class="m-0 text-secondary">Nama Framework</p>
                                            <p class="fw-bold">{{ $data->framework }}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <p class="m-0 text-secondary">Sumber Daya</p>
                                            <p class="fw-bold">{{ $data->power_supply }}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <p class="m-0 text-secondary">Tegangan</p>
                                            <p class="fw-bold">{{ $data->voltage }}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <p class="m-0 text-secondary">IP Edge</p>
                                            <p class="fw-bold">{{ $data->ip }}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <p class="m-0 text-secondary">IP Gateway</p>
                                            <p class="fw-bold">{{ $data->ip_gateway }}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <p class="m-0 text-secondary">Diaktivasi Tanggal</p>
                                            <p class="fw-bold">
                                                @if ($data->activated_at)
                                                    {{ $data->activated_at }}
                                                @else
                                                    [N/A]
                                                @endif
                                            </p>
                                        </div>
                                        <div class="col-md-6">
                                            <p class="m-0 text-secondary">Dipasang Tanggal</p>
                                            <p class="fw-bold">
                                                @if ($data->installed_at)
                                                    {{ $data->installed_at }}
                                                @else
                                                    [N/A]
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- <div class="col-md-12 mt-4">
                            <div class="card">
                                <div class="card-body p-0">
                                    <div id="map" class="map"></div>
                                </div>
                            </div>
                        </div> --}}

                        {{-- Buttons --}}
                        <div class="col-md-12 mt-4 text-end">
                            <a href="{{ route('edge-computing.index') }}"
                                class="btn rounded-3 text-secondary border-secondary px-3"
                                style="background-color: #F4F4F4;">Kembali</a>
                            <form id="Hapus{{ $data->id }}" action="{{ route($route . 'destroy', $data->id) }}"
                                method="POST" class="d-inline-block">
                                @method('DELETE')
                                @csrf
                                <button id="Hapus" type="submit" class="btn btn-danger px-3 ms-2"
                                    onclick="deleteActivity({{ $data->id }})">
                                    Hapus
                                </button>
                            </form>
                            <a href="{{ route($route . 'edit', $data->id) }}" class="btn ms-2 px-3 text-white"
                                style="background-color: #FB9E3A;">Edit Data</a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function Notif() {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Data yang memiliki anak tidak bisa dihapus!'
            });
        }

        @if (session()->has('Gagal'))
            Notif();
        @endif
    </script>
@endsection

@push('footer')
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
        integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
        crossorigin=""></script>
@endpush

@push('script')
    {{-- <script>
    window.onload = function () {
        initMap();
    }

    // initialize leaflet map
    function initMap () {
        const map =  L.map('map', {
                layers:[
                    L.tileLayer('http://{s}.google.com/vt/lyrs=s&x={x}&y={y}&z={z}', {
                        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors. Tiles layer by <a href="https://www.google.com/maps">Google</a>',
                        subdomains:['mt0','mt1','mt2','mt3'],
                        maxZoom: 20,
                    })
                ]
        }).setView([-7.013149037536479, 107.6142476926371], 14);

        L.marker([-7.013149037536479, 107.6142476926371]).addTo(map).bindPopup('Edge', {autoClose:false}).openPopup();
        L.marker([-6.989652258839045, 107.63936449512578]).addTo(map).bindPopup('IOT 1', {autoClose:false}).openPopup();
        L.marker([-7.003805588475774, 107.6392721573175]).addTo(map).bindPopup('IOT 2', {autoClose:false}).openPopup();

        let datasets = [
            [-7.013149037536479, 107.6142476926371],
            [-6.989652258839045, 107.63936449512578],
        ];

        let datasets2 = [
            [-7.013149037536479, 107.6142476926371],
            [-7.003805588475774, 107.6392721573175],
        ];

        L.polyline(datasets, {color: 'blue'}).addTo(map)
        L.polyline(datasets2, {color: 'blue'}).addTo(map)

    }
</script> --}}
@endpush
