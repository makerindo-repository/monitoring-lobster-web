@extends('pages.layouts.app')

@push('header')
    <link rel="stylesheet" href="{{ asset('css/form.css') }}">
    <link rel="stylesheet" href="{{ asset('css/col_4_layout.css') }}">
@endpush

@section('content')
    <div class="container">
        <h4 class="fw-bold mb-0">Edit data Client</h4>
        <p class="text-gray fs-7 mb-4">Harap isi semua form input lalu klik tombol simpan.</p>

        <div class="row justify-content-center">
            <div class="col-md-6">
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
                                <label for="">Nama Client</label>
                                <input type="text" name="name" class="form-control" value="{{ $data->name }}"
                                    placeholder="Masukan Nama" required>
                            </div>
                            <div class="form-group mb-2">
                                <label for="">Keterangan</label>
                                <textarea name="description" class="form-control" rows="6" placeholder="Masukan Keterangan (Opsional)">{{ $data->description }}</textarea>
                            </div>
                            <div class="form-group text-end mt-4">
                                <a href="{{ route($route . 'index') }}"
                                    class="btn rounded-3 text-secondary border-secondary"
                                    style="background-color: #F4F4F4;">Batal</a>
                                <button type="submit" class="btn text-white rounded-3"
                                    style="background-color: #FB9E3A;">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
