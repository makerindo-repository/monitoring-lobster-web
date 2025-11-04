@extends('pages.layouts.app')

@push('header')
    <link rel="stylesheet" href="{{ asset('css/form.css') }}">
    <link rel="stylesheet" href="{{ asset('css/col_4_layout.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.0.1/dist/css/tom-select.css" rel="stylesheet">
@endpush

@section('content')
    <div class="container">
        <h4 class="fw-bold mb-0">Tambah data Kabupaten/Kota</h4>
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
                                <label for="">Nama </label>
                                <input type="text" name="name" class="form-control" value="{{ old('name') }}"
                                    placeholder="Masukan Nama kabupaten atau kota" required>
                            </div>
                            <div class="form-group mb-2">
                                <label for="">Provinsi</label>
                                <select name="region_id" placeholder="Pilih Provinsi" autocomplete="off" required>
                                    @foreach ($regions as $id => $name)
                                        <option value="{{ $id }}" {{ old('region_id') == $id ? 'selected' : '' }}>
                                            {{ $name }}</option>
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


@push('footer')
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.0.1/dist/js/tom-select.complete.min.js"></script>
@endpush

@push('script')
    <script>
        window.onload = function() {
            new TomSelect("[name='region_id']");
        }
    </script>
@endpush
