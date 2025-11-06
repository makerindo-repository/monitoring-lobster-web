@extends('pages.layouts.app')

@push('header')
    <link rel="stylesheet" href="{{ asset('css/form.css') }}">
    <link rel="stylesheet" href="{{ asset('css/col_4_layout.css') }}">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
@endpush

@section('content')
    <div class="container">
        <h4 class="fw-bold mb-0">Tambah data Keramba Jaring Apung (KJA)</h4>
        <p class="text-gray fs-7 mb-4">Harap isi semua form input lalu klik tombol simpan.</p>

        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="p-2 border-flat alert-info fw-bold mb-2" style="font-size:.8em; opacity:.9;">
                    <div>* Isi semua input dengan benar</div>
                </div>
                <div class="card">
                    <div class="card-body">
                        {{-- Error Validation --}}
                        <x-error-validation-message errors="$errors" />

                        <form action="{{ route($route . 'store') }}" method="POST">
                            @csrf
                            <div class="form-group mb-2">
                                <label for="nomor_kja">Nomor KJA</label>
                                <input type="text" name="nomor_kja" id="nomor_kja" class="form-control"
                                    value="{{ old('nomor_kja') }}" placeholder="Masukan Nomor KJA" required>
                            </div>
                            <div class="form-group mb-2">
                                <label for="latitude">Latitude</label>
                                <input type="text" name="latitude" id="latitude" class="form-control"
                                    value="{{ old('latitude') }}" required readonly>
                            </div>
                            <div class="form-group mb-2">
                                <label for="longitude">Longitude</label>
                                <input type="text" name="longitude" id="longitude" class="form-control"
                                    value="{{ old('longitude') }}" required readonly>
                            </div>
                            <div class="form-group mb-2">
                                <label for="dimensi">Dimensi (m2)</label>
                                <input type="number" step="0.01" name="dimensi" id="dimensi" class="form-control"
                                    value="{{ old('dimensi') }}" placeholder="Masukan Dimensi" required min="0">
                            </div>
                            <div class="form-group mb-2">
                                <label for="kondisi">Kondisi</label>
                                <input type="text" name="kondisi" id="kondisi" class="form-control"
                                    value="{{ old('kondisi') }}" placeholder="Masukan Kondisi" required>
                            </div>
                            <div class="form-group text-end mt-4">
                                <a href="{{ route($route . 'index') }}"
                                    class="btn rounded-3 text-secondary border-secondary"
                                    style="background-color: #F4F4F4;">Batal</a>
                                <button type="submit" class="btn text-white"
                                    style="background-color: #FB9E3A;">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="h-80 md:h-full">
                    <div id="map" class="w-full h-full rounded-lg"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('footer')
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
        integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
        crossorigin=""></script>
@endpush

@push('script')
    <script>
        var map = L.map('map', {
            center: [-7.7013023, 108.6563913], // Pangandaran
            zoom: 15,
            zoomControl: false // hilangkan tombol zoom
        });

        // Menambahkan layer peta Google Maps Satelit
        L.tileLayer('https://www.google.cn/maps/vt?lyrs=s,h&x={x}&y={y}&z={z}', {
            attribution: '&copy; Google Hybrid',
            maxZoom: 18,
        }).addTo(map);

        let marker;

        map.on('click', function(e) {
            if (marker) {
                map.removeLayer(marker);
            }
            marker = L.marker(e.latlng).addTo(map);

            // autofill ke input
            document.getElementById('latitude').value = e.latlng.lat;
            document.getElementById('longitude').value = e.latlng.lng;
        });
    </script>
@endpush
