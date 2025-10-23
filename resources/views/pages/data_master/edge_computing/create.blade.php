@extends('pages.layouts.app')

@push('header')
<link rel="stylesheet" href="{{ asset('css/form.css') }}">
<link rel="stylesheet" href="{{ asset('css/col_4_layout.css') }}">
<link href="https://cdn.jsdelivr.net/npm/tom-select@2.0.1/dist/css/tom-select.css" rel="stylesheet">
@endpush

@section('content')
<div class="container mb-5">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="fw-bold mb-0">Tambah data Edge</h5>
                    <p class="text-gray fs-7">Harap isi semua form input lalu klik tombol simpan.</p>
                    
                    {{-- Error Validation --}}
                    <x-error-validation-message errors="$errors" />

                    <form action="{{ route($route . 'store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group mb-2">
                            <label for="">Memory</label>
                            <input type="text" name="memory" class="form-control" value="{{ old('memory') }}" placeholder="Masukan memory" required>
                        </div>
                        <div class="form-group mb-2">
                            <label for="">Processor clock speed</label>
                            <input type="text" name="processor_clock_speed" class="form-control" value="{{ old('processor_clock_speed') }}" placeholder="Masukan Processor clock speed" required>
                        </div>
                        <div class="form-group mb-2">
                            <label for="">Nama OS</label>
                            <input type="text" name="os" class="form-control" value="{{ old('os') }}" placeholder="Masukan OS" required>
                        </div>
                        <div class="form-group mb-2">
                            <label for="">Nama Framework</label>
                            <input type="text" name="framework" class="form-control" value="{{ old('framework') }}" placeholder="Masukan Nama Framework">
                            <small class="text-gray fw-bold" style="font-size:.7em;">* Opsional | Boleh dikosongkan</small>
                        </div>
                        <div class="form-group mb-2">
                            <label for="">Sumber Daya</label>
                            <select name="power_supply" class="form-select" required>
                                <option>AC</option>
                                <option>DC</option>
                                <option>AC & DC</option>
                            </select>
                        </div>
                        <div class="form-group mb-2">
                            <label for="">Tegangan</label>
                            <input type="text" name="voltage" class="form-control" value="{{ old('voltage') }}" placeholder="Masukan Tegangan" required>
                        </div>
                        <div class="form-group mb-2">
                            <label for="">IP Edge</label>
                            <input type="text" name="ip" class="form-control" value="{{ old('ip') }}" placeholder="Masukan IP Edge" required>
                        </div>
                        <div class="form-group mb-2">
                            <label for="">IP Gateway</label>
                            <input type="text" name="ip_gateway" class="form-control" value="{{ old('ip_gateway') }}" placeholder="Masukan IP Gateway" required>
                        </div>
                        <div class="form-group mb-2">
                            <label for="">Maximum IOT Node</label>
                            <input type="number" min="1" name="maximum_iot" class="form-control" value="{{ old('maximum_iot') }}" placeholder="Masukan Maximum device IOT Node" required>
                        </div>
                        <div class="form-group mb-2">
                            <label for="">Lokasi</label>
                            <div class="row">
                                <div class="col-md-6">
                                    <select name="region_id" placeholder="Pilih Provinsi" autocomplete="off" required>
                                        @foreach($regions as $i => $region)
                                        <option value="{{ $region->id }}" {{ old('region_id') == $region->id ? 'selected' : '' }}>{{ $region->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <select name="city_id" autocomplete="off" required></select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="">Foto</label>
                            <input type="file" name="picture" class="form-control" accept="image/png, image/jpg, image/jpeg">
                            <small class="text-gray fw-bold" style="font-size:.7em;">* Opsional | Boleh dikosongkan</small>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Simpan & Generate</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="p-2 border-flat alert-info fw-bold" style="font-size:.8em; opacity:.9;">
                <div>* Foto hanya menerima ekstensi PNG/JPG/JPEG</div>
                <div>* Foto hanya menerima ukuran maksimum 1MB</div>
                <div>* Isi semua input dengan benar</div>
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
    let selectedCityId = "{{ old('city_id') }}" || false;

    window.onload = function () {
        setCity(getRegionId(), selectedCityId);
        new TomSelect("[name='region_id']", {
            onChange: (id) => setCity(id)
        });
    }
    
    function getRegionId () {
        return document.querySelector('[name="region_id"]').value;
    }

    function setCity (id, selected_id = false) {
        let object = objects.find(row => row.id == id);
        if (object) {
            let raw = '';
            for (let i = 0; i < object.cities.length; i++) {
                raw += `<option value="${object.cities[i].id}" ${selected_id == object.cities[i].id ? 'selected' : ''} >${object.cities[i].name}</option>`;
            }
            if (raw.length !== '') setOptions(raw);
        }
    }

    function setOptions (element) {
        if (cityOptions) cityOptions.destroy();
        document.querySelector('[name="city_id"]').innerHTML = element;
        cityOptions = new TomSelect("[name='city_id']");
    }
</script>
@endpush