@extends('pages.layouts.app')

@push('header')
    <link rel="stylesheet" href="{{ asset('css/form.css') }}">
    <link rel="stylesheet" href="{{ asset('css/col_4_layout.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.0.1/dist/css/tom-select.css" rel="stylesheet">
@endpush

@section('content')
    <div class="container">
        <h4 class="fw-bold mb-0">Edit data IOT</h4>
        <p class="text-gray fs-7 mb-4">Harap isi semua form input lalu klik tombol simpan.</p>

        <div class="row justify-content-center g-3">
            <div class="col-md-10">
                <div class="p-2 border-flat alert-info fw-bold" style="font-size:.8em; opacity:.9;">
                    <div>* Foto hanya menerima ekstensi PNG/JPG/JPEG</div>
                    <div>* Foto hanya menerima ukuran maksimum 1MB</div>
                    <div>* Isi semua input dengan benar</div>
                </div>
            </div>

            <div class="col-md-10">
                <div class="card">
                    <div class="card-body">
                        {{-- Error Validation --}}
                        <x-error-validation-message errors="$errors" />

                        <form action="{{ route($route . 'update', $data->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')
                            <div class="row">
                                <div class="form-group mb-2 col-md-6">
                                    <label for="">Nomor Serial</label>
                                    <input type="text" name="serial_number" class="form-control"
                                        value="{{ $data->serial_number }}" placeholder="Masukan nomor serial" required>
                                </div>
                                <div class="form-group mb-2 col-md-6">
                                    <label for="">Edge Computing</label>
                                    <select name="edge_computing_id" autocomplete="off" required>
                                        @foreach ($edges as $edge)
                                            <option value="{{ $edge->id }}"
                                                {{ $data->edge_computing_id == $edge->id ? 'selected' : '' }}>
                                                {{ $edge->serial_number }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group mb-2 col-md-6">
                                    <label for="">Edge Computing Node</label>
                                    <input type="number" min="1" name="edge_computing_node" class="form-control"
                                        placeholder="Masukan Nth Node Edge Computing "
                                        value="{{ $data->edge_computing_node }}" required>
                                </div>
                                <div class="form-group mb-2">
                                    <label for="">Lokasi</label>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <select name="region_id" placeholder="Pilih Provinsi" autocomplete="off"
                                                required>
                                                @foreach ($regions as $i => $region)
                                                    <option value="{{ $region->id }}"
                                                        {{ $data->city->region_id == $region->id ? 'selected' : '' }}>
                                                        {{ $region->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <select name="city_id" autocomplete="off" required></select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-3 col-md-6">
                                    <label for="">Foto</label>
                                    <input type="file" name="picture" class="form-control"
                                        accept="image/png, image/jpg, image/jpeg">
                                    <small class="text-gray fw-bold" style="font-size:.7em;">* Opsional | Boleh
                                        dikosongkan</small>
                                </div>
                                <div class="form-group col-12 text-end">
                                    <a href="{{ route('iot-node.index') }}"
                                        class="btn rounded-3 text-secondary border-secondary"
                                        style="background-color: #F4F4F4;">Batal</a>
                                    <button type="submit" class="btn text-white" style="background-color: #FB9E3A;">Simpan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('footer')
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.0.1/dist/js/tom-select.complete.min.js"></script>
@endpush

@push('script')
    <script>
        let objects = JSON.parse(`{!! json_encode($regions->toArray()) !!}`);
        let cityOptions = false;
        let selectedCityId = "{{ $data->city_id }}" || false;

        window.onload = function() {
            setCity(getRegionId(), selectedCityId);
            new TomSelect("[name='region_id']", {
                onChange: (id) => setCity(id)
            });
            new TomSelect("[name='edge_computing_id']");
        }

        function getRegionId() {
            return document.querySelector('[name="region_id"]').value;
        }

        function setCity(id, selected_id = false) {
            let object = objects.find(row => row.id == id);
            if (object) {
                let raw = '';
                for (let i = 0; i < object.cities.length; i++) {
                    raw +=
                        `<option value="${object.cities[i].id}" ${selected_id == object.cities[i].id ? 'selected' : ''} >${object.cities[i].name}</option>`;
                }
                if (raw.length !== '') setOptions(raw);
            }
        }

        function setOptions(element) {
            if (cityOptions) cityOptions.destroy();
            document.querySelector('[name="city_id"]').innerHTML = element;
            cityOptions = new TomSelect("[name='city_id']");
        }
    </script>
@endpush
