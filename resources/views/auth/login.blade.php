@extends('auth.layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card mt-5">
                <div class="card-body pb-4 pt-3">
                    <center>
                        <img src="{{ asset('images/logo-diktisaintek.jpg') }}" alt="Logo" width="110px" style="margin-right: 20px;">
                        <img src="{{ asset('images/unpad-logo.png') }}" alt="Logo" width="90px">
                    </center>
                    <h5 class="text-center fw-bolder mt-3 mb-4" style="display: block; word-wrap: break-word;">
                        Sistem Monitoring Lobster
                    </h5>

                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="my-3 px-3">
                            <div class="form-group mb-3">
                                <label for="email" class="fw-bold mb-2">{{ __('E-Mail') }}</label>
                                <input type="email" id="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" required autocomplete="email" autofocus placeholder="Masukan Email">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group mb-2">
                                <label for="password" class="fw-bold mb-2">{{ __('Password') }}</label>
                                <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" required autocomplete="current-password" autofocus placeholder="Masukan Password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Ingatkan saya di perangkat ini') }}
                                    </label>
                                </div>
                            </div>
                            <div class="form-group d-grid gap-2 mt-3">
                                <button type="submit" class="btn btn-primary btn-block fw-bold py-2">
                                    <img src="{{ asset('svg/login/log-in.svg') }}" alt="ic" class="icon">
                                    {{ __('Masuk') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="copyright">
    <h6><b>{{ get_app_info('name') }}</b> V{{ get_app_info('version') }} | Copyright © 2023 {{ get_app_info('copyright') }}</h6>
</div>
@endsection

@push('footer')
<script src="{{ asset('js/disabledSubmitButton.js') }}"></script>
@endpush
