@extends('pages.layouts.app')

@push('header')
    <link rel="stylesheet" href="{{ asset('css/form.css') }}">
    <link rel="stylesheet" href="{{ asset('css/col_4_layout.css') }}">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
@endpush

@section('content')
    <div class="container">
        <h4 class="fw-bold mb-0">Edit data Log Pakan</h4>
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

                        <form action="{{ route($route . 'update', $data->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <div class="form-group mb-2">
                                <label for="pemberian_ke">Pemberian Ke</label>
                                <input type="number" name="pemberian_ke" id="pemberian_ke" class="form-control"
                                    value="{{ $data->pemberian_ke }}" required min="1" step="1">
                            </div>
                            <div class="form-group mb-2">
                                <label for="jenis_pakan">Jenis Pakan</label>
                                <input type="text" name="jenis_pakan" id="jenis_pakan" class="form-control"
                                    value="{{ $data->jenis_pakan }}" placeholder="Masukan Jenis Pakan" required>
                            </div>
                            <div class="form-group mb-2">
                                <label for="berat">Berat (Kg)</label>
                                <input type="number" name="berat" id="berat" class="form-control"
                                    value="{{ $data->berat }}" required min="0" step="0.01">
                            </div>
                            <div class="form-group mb-2">
                                <label for="kja">KJA</label>
                                <select name="kja" id="kja" class="form-control" required>
                                    <option value="">Pilih KJA</option>
                                    @foreach ($kja as $row)
                                        <option value="{{ $row->id }}" {{ $row->id == $data->kja_id ? 'selected' : '' }}>
                                            {{ $row->nomor_kja }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mb-2">
                                <label for="petugas">Petugas</label>
                                <select name="petugas" id="petugas" class="form-control" required>
                                    <option value="">Pilih Petugas</option>
                                    @foreach ($petugas as $row)
                                        <option value="{{ $row->id }}" {{ $row->id == $data->petugas_id ? 'selected' : '' }}>
                                            {{ $row->nama }}</option>
                                    @endforeach
                                </select>
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
        </div>
    </div>
@endsection
