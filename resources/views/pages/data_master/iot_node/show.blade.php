@extends('pages.layouts.app')

@push('header')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
        integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
        crossorigin="" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.2.0/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.css" />
@endpush

@push('style')
    <style>
        #map {
            height: 350px;
        }

        .leaflet-routing-container {
            display: none !important;
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
                                            <td width="20%">Nomor Serial</td>
                                            <td width="1%">:</td>
                                            <td class="fw-bold">{{ $data->serial_number }}</td>
                                        </tr>
                                        <tr>
                                            <td>Edge Computing</td>
                                            <td>:</td>
                                            <td class="fw-bold">
                                                @if ($data->edge_computing_id)
                                                    <a href="{{ route('edge-computing.show', $data->edge_computing_id) }}"
                                                        style="color: #0a58ca"
                                                        title="Lihat Detail">{{ $data->edge_computing->serial_number }}</a>
                                                    - Node {{ $data->edge_computing_node }}
                                                @else
                                                    undefined
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Diaktivasi Oleh</td>
                                            <td>:</td>
                                            <td class="fw-bold">
                                                @if ($data->activated_by)
                                                    {{ $data->user->name }}
                                                @else
                                                    [N/A]
                                                @endif
                                            </td>
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
                                            <td class="fw-bold">
                                                @if ($data->installed_at)
                                                    {{ $data->installed_at }}
                                                @else
                                                    [N/A]
                                                @endif
                                            </td>
                                        </tr>
                                        <input id="id" value="{{ $data->edge_computing_id }}" hidden>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 mt-4">
                        <div class="card">
                            <div class="card-body p-0">
                                <div id="map" class="map"></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 mt-4 text-end">
                        <a href="{{ route($route . 'edit', $data->id) }}" class="btn btn-primary me-2">Edit Data</a>
                        <form action="{{ route($route . 'destroy', $data->id) }}" method="POST" class="d-inline-block"
                            id="Hapus{{ $data->id }}">
                            @method('DELETE')
                            @csrf
                            <button id="Hapus" type="submit" class="btn btn-outline-danger"
                                onclick="deleteActivity({{ $data->id }})">
                                Hapus
                            </button>
                        </form>
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
    <script src="https://unpkg.com/leaflet@1.2.0/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.js"></script>
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
@endpush

@push('script')
    {{-- <script>
        window.onload = function() {
            const eNode = document.getElementById('id');
            const value = eNode.value;
            const API_URL = `${_base_url}/api/lokasi?edge_computing_id=` + value;

            fetch(API_URL)
                .then(resp => resp.json())
                .then(resp => {
                    if (resp.data && resp.data.length > 0) {
                        const nodeLocations = {
                            lat: resp.data[0].lat,
                            lng: resp.data[0].lng
                        };

                        const edgeLocations = {
                            lat: resp.data[0].edge_computing.lat,
                            lng: resp.data[0].edge_computing.lng
                        };

                        console.log(nodeLocations);
                        console.log(edgeLocations);
                        initMap(nodeLocations, edgeLocations);
                    }
                });
        }

        // initialize leaflet map
        function initMap(nodeLocations, edgeLocations) {
            const map = L.map('map', {
                layers: [
                    L.tileLayer('http://{s}.google.com/vt/lyrs=s&x={x}&y={y}&z={z}', {
                        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors. Tiles layer by <a href="https://www.google.com/maps">Google</a>',
                        subdomains: ['mt0', 'mt1', 'mt2', 'mt3'],
                        maxZoom: 20,
                    })
                ]
            }).setView([nodeLocations.lat , nodeLocations.lng], 14);

            L.marker([edgeLocations.lat, edgeLocations.lng]).addTo(map).bindPopup('Edge', {
                autoClose: false
            }).openPopup();
            L.marker([nodeLocations.lat , nodeLocations.lng]).addTo(map).bindPopup('Node', {
                autoClose: false
            }).openPopup();

            let datasets = [
                [edgeLocations.lat, edgeLocations.lng],
                [nodeLocations.lat , nodeLocations.lng],
            ];

            L.Routing.control({
                waypoints: [
                    L.latLng(nodeLocations.lat , nodeLocations.lng),
                    L.latLng(edgeLocations.lat, edgeLocations.lng),
                ],
                routeWhileDragging: false,
                collapsible: false,
                show: false,
                lineOptions: {
                    styles: [{
                        color: '#0080FE'
                    }]
                }

            }).addTo(map);

        }
    </script> --}}
    <script>
        function initMap() {
            const map = L.map('map', {
                layers: [
                    L.tileLayer('http://{s}.google.com/vt/lyrs=s&x={x}&y={y}&z={z}', {
                        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors. Tiles layer by <a href="https://www.google.com/maps">Google</a>',
                        subdomains: ['mt0', 'mt1', 'mt2', 'mt3'],
                        maxZoom: 20,
                    })
                ]
            }).setView([-2.5489, 118.0149], 4); // Set default

            return map;
        }

        // fetch data
        window.onload = function() {
            const map = initMap(); // Inisialisasi the map
            const eNode = document.getElementById('id');
            const value = eNode.value;
            const API_URL = `${_base_url}/api/lokasi?edge_computing_id=` + value;

            fetch(API_URL)
                .then(resp => resp.json())
                .then(resp => {
                    if (resp.data && resp.data.length > 0) {
                        const nodeLocations = {
                            lat: resp.data[0].lat,
                            lng: resp.data[0].lng
                        };

                        const edgeLocations = {
                            lat: resp.data[0].edge_computing.lat,
                            lng: resp.data[0].edge_computing.lng
                        };


                        // tambah marker
                        L.marker([nodeLocations.lat, nodeLocations.lng]).addTo(map).bindPopup('IOT 1', {
                            autoClose: false,
                            draggable: false,
                        }).openPopup();
                        L.marker([edgeLocations.lat, edgeLocations.lng]).addTo(map).bindPopup('Edge', {
                            autoClose: false,
                            draggable: false,
                        }).openPopup();

                        // buat point jalan
                        const waypoints = [
                            L.latLng(nodeLocations.lat, nodeLocations.lng),
                            L.latLng(edgeLocations.lat, edgeLocations.lng)
                        ];

                        // tambah routing control
                        L.Routing.control({
                            waypoints,
                            routeWhileDragging: false,
                            collapsible: false,
                            show: false,
                            draggable: false,
                            draggableWaypoints: false,
                            lineOptions: {
                                styles: [{
                                    color: '#0080FE'
                                }]
                            }
                        }).addTo(map);
                    }
                });
        }
    </script>
@endpush
