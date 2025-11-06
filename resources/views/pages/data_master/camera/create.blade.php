@extends('pages.layouts.app')

@push('header')
    <link rel="stylesheet" href="{{ asset('css/form.css') }}">
    <link rel="stylesheet" href="{{ asset('css/col_4_layout.css') }}">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
@endpush

@section('content')
    <div class="container">
        <h4 class="fw-bold mb-0">Tambah data Kamera</h4>
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
                                <label for="id_kamera">ID Kamera</label>
                                <input type="text" name="id_kamera" id="id_kamera" class="form-control"
                                    value="{{ old('id_kamera') }}" placeholder="Masukan ID Kamera" required>
                            </div>
                            <div class="form-group mb-2">
                                <label for="kja_id">KJA</label>
                                <select name="kja_id" id="kja_id" class="form-control" required>
                                    <option value="">Pilih KJA</option>
                                    @foreach ($kja as $row)
                                        <option value="{{ $row->id }}">{{ $row->nomor_kja }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mb-2">
                                <label for="ip_kamera">IP Kamera</label>
                                <input type="text" name="ip_kamera" id="ip_kamera" class="form-control"
                                    value="{{ old('ip_kamera') }}" placeholder="Masukan IP Kamera" required>
                            </div>
                            <div class="form-group mb-2">
                                <label for="status">Status</label>
                                <select name="status" id="status" class="form-control" required>
                                    <option value="">Pilih Status</option>
                                    <option value="1">Aktif</option>
                                    <option value="0">Tidak Aktif</option>
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
