@extends('pages.layouts.app')

@push('header')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
        integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A==" crossorigin="" />
        <link rel="stylesheet" href="https://unpkg.com/leaflet-geosearch@3.1.0/dist/geosearch.css" />

@endpush
@push('style')
    <style>
        #map {
            height: 450px;
        }

        .select-wrapper {
            position: absolute;
            z-index: 999;
            right: 8px;
            top: 10px;
        }
        .leaflet-control-geosearch form input {
    min-width: 140px;
    width: 80%;
    outline: none;
    border: none;
    margin: 0;
    padding: 0;
    font-size: 12px;
    height: 30px;
    border: none;
    border-radius: 0 4px 4px 0;
    text-indent: 8px;
}
    </style>
@endpush

@section('content')
    {{-- Modal Detail Informasi Edge --}}
    <div class="modal fade" id="modalDetailEdge" tabindex="-1" aria-labelledby="modalDetailEdgeLabel" aria-hidden="true"
        style="font-size:.85em !important;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header py-2">
                    <h6 class="modal-title" id="modalDetailEdgeLabel">Detail Informasi Edge</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                </div>
            </div>
        </div>
    </div>

    <div class="container mb-5">
        <div class="row">
            <div class="col-md-12">
                <div class="toggle-switch">

                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="card" style="border: 1px solid rgb(220 221 222);">
                    <div class="card-body p-0" style="position: relative; overflow: hidden;">
                        <div id="map" class="map"></div>
                        {{-- <div class="select-wrapper">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <select id="region-select" name="region-select" class="form-select form-select-sm">
                                            @foreach ($regions as $id => $region)
                                                <option {!! $id === $currentLocation->id ? 'selected' : '' !!} value="{{ $id }}">
                                                    {{ $region }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="fw-bold mb-0">Informasi</h5>
                                <p class="text-gray fs-7 mb-2">Detail Informasi Edge</p>
                                <div class="row">
                                    <div class="col-md-12" id="konten-detail-informasi-edge">
                                        <div class="text-center">
                                            <br>
                                            <small class="text-gray">- Tidak ada marker Edge yang dipilih. -</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="fw-bold mb-0">IOT Node</h5>
                                <p class="text-gray fs-7 mb-2">Daftar IOT Node yang sudah diaktivasi</p>
                                <div class="table-responsive">
                                    <table id="table-iot-nodes" class="table" style="font-size:.85em;">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>IOT Node</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td colspan="3">-</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

{{-- SCRIPTS IN APP --}}
@push('footer')
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
        integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
        crossorigin=""></script>
    <script src="https://unpkg.com/leaflet-geosearch@3.1.0/dist/geosearch.umd.js"></script>
@endpush
@push('script')
    <script>
        // state data
        let selectedData = '';

        window.onload = function() {
            initMap();
        }

        // initialize leaflet map
        function initMap() {
            let centerPoint = [
                -1.3450239,118.8061376
            ]

            let marker = L.marker(centerPoint)

            const map = L.map('map', {
                layers: [
                    L.tileLayer('http://{s}.google.com/vt/lyrs=s&x={x}&y={y}&z={z}', {
                        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors. Tiles layer by <a href="https://www.google.com/maps">Google</a>',
                        subdomains: ['mt0', 'mt1', 'mt2', 'mt3'],
                        maxZoom: 20,
                    })
                ]
            }).setView(centerPoint, 4);
            var provider = new GeoSearch.OpenStreetMapProvider();
        const searchControl = new GeoSearch.GeoSearchControl({
            provider: provider,
            style: 'button',
            showMarker: false,
            showPopup: false,
            autoClose: true,
            retainZoomLevel: false,
            animateZoom: true,
            keepResult: true,
            updateMap: true,
            searchLabel: 'Cari Lokasi',
            popupFormat: ({
                query,
                result
            }) => result.label,
        });
        searchControl.addTo(map);

            fetch("{{ route('edges-marker') }}")
                .then(response => response ? response.json() : response)
                .then(response => {
                    L.geoJSON(response, {
                        pointToLayer: function(geoJsonPoint, latlng) {
                            console.log(response);
                            return L.marker(latlng)
                        },
                        onEachFeature: function(feature, layer) {
                            let latlng = feature.geometry.coordinates[1] + ',' + feature.geometry
                                .coordinates[0];
                            layer.on('click', function() {
                                setDetail(feature.properties);
                                setNodeList(feature.properties.iot_nodes,latlng);
                            })
                        }
                    }).addTo(map)
                });
        }

        function getDetailData(id) {
            fetch(`${_base_url}/api/detail-marker-edge?id=${id}`)
                .then(r => r ? r.json() : r)
                .then(r => {
                    if (r) {
                        setDetail(r.data);
                        setNodeList(r.data.iot_nodes);
                    }
                });
        }

        function setDetail(data) {
            document.getElementById('konten-detail-informasi-edge')
                .innerHTML = `
            <table class="table mb-1" style="font-size:.85em;">
                <tr>
                    <td width="26%">Nomor Serial</td>
                    <td width="1%">:</td>
                    <td>${data.serial_number}</td>
                </tr>
                <tr>
                    <td>Total IOT Node</td>
                    <td width="1%">:</td>
                    <td>${data.iot_nodes.length}</td>
                </tr>
                <tr>
                    <td>Diaktivasi Tanggal</td>
                    <td width="1%">:</td>
                    <td>${data.activated_at}</td>
                </tr>
                <tr>
                    <td>Diaktivasi Oleh</td>
                    <td width="1%">:</td>
                    <td><b>Petugas</b></td>
                </tr>
            </table>
            <span class="fw-bolder d-inline-block fs-7 ms-1" data-bs-toggle="modal" data-bs-target="#modalDetailEdge" style="color:#1e88e5; cursor: pointer;">Lihat lebih lengkap</span>
        `;

            document.querySelector('#modalDetailEdge .modal-body')
                .innerHTML = `
            <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <h5 class="badge rounded-pill bg-outline-success">
                                Sudah diaktivasi
                            </h5>
                            <table class="table">
                                <tr>
                                    <td width="25%">Nomor Serial</td>
                                    <td width="1%">:</td>
                                    <td class="fw-bold">${data.serial_number}</td>
                                </tr>
                                <tr>
                                    <td>Memory</td>
                                    <td>:</td>
                                    <td class="fw-bold">${data.memory}</td>
                                </tr>
                                <tr>
                                    <td>Processor Clock Speed</td>
                                    <td>:</td>
                                    <td class="fw-bold">${data.processor_clock_speed}</td>
                                </tr>
                                <tr>
                                    <td>Nama OS</td>
                                    <td>:</td>
                                    <td class="fw-bold">${data.os}</td>
                                </tr>
                                <tr>
                                    <td>Nama Framework</td>
                                    <td>:</td>
                                    <td class="fw-bold">${data.framework}</td>
                                </tr>
                                <tr>
                                    <td>Sumber Daya</td>
                                    <td>:</td>
                                    <td class="fw-bold">${data.power_supply}</td>
                                </tr>
                                <tr>
                                    <td>Tegangan (Volt)</td>
                                    <td>:</td>
                                    <td class="fw-bold">${data.voltage}</td>
                                </tr>
                                <tr>
                                    <td>IP Edge</td>
                                    <td>:</td>
                                    <td class="fw-bold">${data.ip}</td>
                                </tr>
                                <tr>
                                    <td>IP Gateway</td>
                                    <td>:</td>
                                    <td class="fw-bold">${data.ip_gateway}</td>
                                </tr>
                                <tr>
                                    <td>Diaktivasi Tanggal</td>
                                    <td>:</td>
                                    <td class="fw-bold">${data.activated_at}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="row mt-4 ps-2">
                    <div class="col-md-6">
                        <h6 class="text-gray mb-2">Foto Instalasi Edge</h6>

                    </div>
                </div>
            `;
        }

        function setNodeList(data, latlng) {
    let raw = '';
    let currentDate = new Date();

    let formattedDate = currentDate.toISOString().split('T')[0];

    data.filter(d => d.activated_at).forEach((r, i) => {
        raw += `
            <tr>
                <td>${i + 1}</td>
                <td>
                    ${r.serial_number};
                    <small class="text-gray">Node-${r.edge_computing_node}</small>
                </td>
                <td>
                    <a href="{{ route('monitoring.live') }}?n=${r.serial_number}&date=${formattedDate}&latlng=${latlng}" target="_blank" rel="nofollow" class="btn btn-sm fw-bold text-white" style="font-size:.9em !important; background: #1e88e5;">Lihat Detail</a>
                </td>
            </tr>
        `;
    });

    document.getElementById('table-iot-nodes').innerHTML = raw;
}

    </script>
@endpush
