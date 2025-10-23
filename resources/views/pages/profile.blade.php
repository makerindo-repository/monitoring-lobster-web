@extends('pages.layouts.app')

@push('header')
<link rel="stylesheet" href="{{ asset('css/form.css') }}">
<link rel="stylesheet" href="{{ asset('css/col_4_layout.css') }}">
<style>
    .profile-picture-container {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        overflow: hidden;
    }

    .profile-picture-container img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
</style>
@endpush

@section('content')
<div class="container mb-5">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="fw-bold mb-0">Edit Profile</h5>
                    <p class="text-gray fs-7">Harap isi semua form input lalu klik tombol simpan.</p>

                    {{-- Error Validation --}}
                    <x-error-validation-message errors="$errors" />

                    {{-- Alert Message --}}
                    @if(session()->has('success'))
                    <div class="row">
                        <div class="col-md-12">
                            <x-success-message action="{{ session()->get('success') }}" />
                        </div>
                    </div>
                    @endif

                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <center>
                        <div class="form-group mb-2">
                            <div class="profile-picture-container">
                                    <img id="profile-picture-preview" src="{{ url('images/user', auth()->user()->picture) }}" alt="Profile Picture" height="80" width="80">
                                </div>
                                <br>
                                <input type="file" name="picture" id="profile-picture-input" class="form-control" accept="image/*" onchange="previewProfilePicture()">
                            </div>
                        </center>
                        <div class="form-group mb-2">
                            <label for="">Nama</label>
                            <input type="text" name="name" class="form-control" value="{{ auth()->user()->name }}" placeholder="Masukan Nama" required>
                        </div>
                        <div class="form-group mb-2">
                            <label for="">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ auth()->user()->email }}" placeholder="Masukan Email" required>
                        </div>
                        <div class="form-group mb-2">
                            <label for="">Password <small class="text-gray">* Optional</small></label>
                            <input type="password" name="password" class="form-control" placeholder="Masukan Password">
                            <div class="required fs-7 text-gray ps-2 pt-1">
                                <div>&check; Password minimal 6 digit</div>
                                <div>&check; Password wajib mengandung Angka numeric</div>
                                <div>&check; Password wajib mengandung huruf spesial</div>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Simpan </button>
                        </div>
                        <hr>
                        <div class="p-2 border-flat alert-info fw-bold" style="font-size:.8em; opacity:.9;">
                            <div>* Isi semua input dengan benar</div>
                            <div>* Password Optional</div>
                            <div>* Isi Password jika ingin diubah</div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
    function previewProfilePicture() {
        const input = document.getElementById('profile-picture-input');
        const preview = document.getElementById('profile-picture-preview');

        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function (e) {
                preview.src = e.target.result;
            };

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>

<script>
    let elemBtn = document.querySelector('button[type="submit"]');
    window.onload = function () {
        document.querySelector('input[name="password"]').addEventListener('keyup', function () {
            let {value}    = this;
            let elems      = document.querySelectorAll('.required div');
            let validation = [
                (value.length >= 6),
                /[0-9]/.test(value),
                /[^a-zA-Z0-9 ]/.test(value)
            ];

            for (let i = 0; i < 3; i++) {
                if (validation[i])  elems[i].classList.add('text-success', 'fw-bold');
                else elems[i].classList.remove('text-success', 'fw-bold');
            }

            if (value.length > 0) {
                if (validation.every(v => v)) {
                    elemBtn.removeAttribute('disabled');
                } else {
                    elemBtn.setAttribute('disabled', true)
                }
            } else {
                elemBtn.removeAttribute('disabled');
            }

        });
    }
</script>
@endpush
