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
        <div class="row">
            <div class="col-md-4">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
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
                        <div class="card" style="font-size:.9em;">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <h5
                                        class="badge rounded-pill bg-outline-{{ $data->activated_by ? 'success' : 'warning' }}">
                                        {{ $data->activated_by ? 'Sudah' : 'Belum' }} diaktivasi
                                    </h5>
                                    <table class="table">
                                        <tr>
                                            <td width="28%">Nomor Serial</td>
                                            <td width="1%">:</td>
                                            <td class="fw-bold">{{ $data->serial_number }}</td>
                                        </tr>

                                        <tr>
                                            <td>Memory</td>
                                            <td>:</td>
                                            <td class="fw-bold">{{ $data->memory }}</td>
                                        </tr>
                                        <tr>
                                            <td>Total IOT Node</td>
                                            <td>:</td>
                                            <td class="fw-bold">{{ $data->iot_nodes->count() }}</td>
                                        </tr>
                                        <tr>
                                            <td>Maksimal IOT Node</td>
                                            <td>:</td>
                                            <td class="fw-bold">{{ $data->maximum_iot }}</td>
                                        </tr>
                                        <tr>
                                            <td>Processor Clock Speed</td>
                                            <td>:</td>
                                            <td class="fw-bold">{{ $data->processor_clock_speed }}</td>
                                        </tr>
                                        <tr>
                                            <td>Nama OS</td>
                                            <td>:</td>
                                            <td class="fw-bold">{{ $data->os }}</td>
                                        </tr>
                                        <tr>
                                            <td>Nama Framework</td>
                                            <td>:</td>
                                            <td class="fw-bold">{{ $data->framework }}</td>
                                        </tr>
                                        <tr>
                                            <td>Sumber Daya</td>
                                            <td>:</td>
                                            <td class="fw-bold">{{ $data->power_supply }}</td>
                                        </tr>
                                        <tr>
                                            <td>Tegangan</td>
                                            <td>:</td>
                                            <td class="fw-bold">{{ $data->voltage }}</td>
                                        </tr>
                                        <tr>
                                            <td>IP Edge</td>
                                            <td>:</td>
                                            <td class="fw-bold">{{ $data->ip }}</td>
                                        </tr>
                                        <tr>
                                            <td>IP Gateway</td>
                                            <td>:</td>
                                            <td class="fw-bold">{{ $data->ip_gateway }}</td>
                                        </tr>
                                        <tr>
                                            <td>Diaktivasi Tanggal</td>
                                            <td>:</td>
                                            <td class="fw-bold">
                                                @if ($data->activated_at)
                                                    {{ $data->activated_at }}
                                                @else
                                                    [N/A]
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Dipasang Tanggal</td>
                                            <td>:</td>
                                            <td class="fw-bold"> @if($data->installed_at)
                                                {{ $data->installed_at }}
                                            @else
                                                [N/A]
                                            @endif</td>
                                        </tr>
                                    </table>
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

                    <div class="col-md-12 mt-4 text-end">
                        <a href="{{ route($route . 'edit', $data->id) }}" class="btn btn-primary me-2">Edit Data</a>
                        <form id="Hapus{{ $data->id }}" action="{{ route($route . 'destroy', $data->id) }}" method="POST" class="d-inline-block">
                            @method('DELETE')
                            @csrf
                            <button id="Hapus" type="submit" class="btn btn-outline-danger" onclick="deleteActivity({{$data->id}})">
                                Hapus
                            </button>                        </form>
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

        @if(session()->has('Gagal'))
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
