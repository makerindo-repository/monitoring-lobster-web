@extends('pages.layouts.app')

@push('header')
<link rel="stylesheet" href="{{ asset('css/form.css') }}">
<link rel="stylesheet" href="{{ asset('css/col_4_layout.css') }}">
@endpush

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="fw-bold mb-0">Edit data Sensor</h5>
                    <p class="text-gray fs-7">Harap isi semua form input lalu klik tombol simpan.</p>

                    {{-- Error Validation --}}
                    <x-error-validation-message errors="$errors" />

                    <form action="{{ route($route . 'update', $data->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="form-group mb-2">
                            <label for="">Nama Sensor</label>
                            <input type="text" name="namaSensor" class="form-control" value="{{ $data->namaSensor }}" placeholder="Masukan Nama Sensor" required>
                        </div>
                        <div class="form-group mb-2">
                            <label for="">Rentang Nilai</label>
                            <input type="text" name="rentangNilai" class="form-control" value="{{ $data->rentangNilai }}" placeholder="Masukan Rentang Nilai" required>
                        </div>
                        <div class="form-group mb-2">
                            <label for="">Keterangan</label>
                            <input type="text" name="keterangan" class="form-control" value="{{ $data->keterangan }}" placeholder="Masukan Keterangan" required>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Simpan </button>
                        </div>
                        <hr>
                        <div class="p-2 border-flat alert-info fw-bold" style="font-size:.8em; opacity:.9;">
                            <div>* Isi semua input dengan benar</div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
