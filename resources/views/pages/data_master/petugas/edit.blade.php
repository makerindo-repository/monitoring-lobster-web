@extends('pages.layouts.app')

@push('header')
    <link rel="stylesheet" href="{{ asset('css/form.css') }}">
    <link rel="stylesheet" href="{{ asset('css/col_4_layout.css') }}">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
@endpush

@section('content')
    <div class="container">
        <h4 class="fw-bold mb-0">Edit data Petugas</h4>
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
                                <label for="nama">Nama Petugas</label>
                                <input type="text" name="nama" id="nama" class="form-control"
                                    value="{{ $data->nama }}" placeholder="Masukan Nama Petugas" required>
                            </div>
                            <div class="form-group mb-2">
                                <label for="nomor_telepon">No. Telepon</label>
                                <input type="tel" name="nomor_telepon" id="nomor_telepon" class="form-control"
                                    value="{{ $data->nomor_telepon }}" placeholder="Masukan No. Telepon" required>
                            </div>
                            <div class="form-group mb-2">
                                <label for="alamat">Alamat</label>
                                <textarea name="alamat" id="alamat" class="form-control" placeholder="Masukan Alamat" required>{{ $data->alamat }}</textarea>
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
