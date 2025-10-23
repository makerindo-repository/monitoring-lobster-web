@extends('pages.layouts.app')

@push('header')
    <link rel="stylesheet" href="{{ asset('css/form.css') }}">
    <style>
        small {
    font-size: 10px; /* Atur ukuran font yang diinginkan */
}
    </style>
@endpush

@section('content')
    <div class="container mb-5">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="fw-bold mb-0">Pengaturan Aplikasi</h5>
                        <p class="text-gray fs-7">Harap isi semua form input lalu klik tombol simpan.</p>

                        {{-- Error Validation --}}
                        <x-error-validation-message errors="$errors" />

                        {{-- Alert Message --}}
                        @if (session()->has('success'))
                            <div class="row">
                                <div class="col-md-12">
                                    <x-success-message action="{{ session()->get('success') }}" />
                                </div>
                            </div>
                        @endif

                        <form action="{{ route('setting.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')
                            <div class="form-group mb-2">
                                <label for="">Nama Aplikasi</label>
                                <input type="text" name="name" class="form-control"
                                    value="{{ $data ? $data->name : '' }}" placeholder="Masukan Nama" required>
                            </div>
                            <div class="form-group mb-2">
                                <label for="">Nama PT</label>
                                <input type="text" name="pt_name" class="form-control"
                                    value="{{ $data ? $data->pt_name : '' }}" placeholder="Masukan Nama PT" required>
                            </div>
                            <div class="form-group mb-2">
                                <label for="">Deskripsi</label>
                                <textarea name="description" class="form-control" rows="5">{{ $data ? $data->description : '' }}</textarea>
                            </div>
                            <div class="form-group mb-2">
                                <label for="">Versi</label>
                                <input type="text" name="version" class="form-control"
                                    value="{{ $data ? $data->version : '' }}" placeholder="Masukan Versi" required>
                            </div>
                            <div class="form-group mb-2">
                                <label for="">Copyright</label>
                                <input type="text" name="copyright" class="form-control"
                                    value="{{ $data ? $data->copyright : '' }}" placeholder="Masukan Copyright" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="formFile" class="form-label">Logo Aplikasi</label>
                                <input class="form-control" type="file" id="formFile" name="logo">
                                @if ($data->logo)
                                    <br>
                                    <img src="{{ asset($data->logo) }}" alt="logo" width="100px">
                                @else
                                    <small class="text-warning fs-7">Belum ada logo</small>
                                @endif
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
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <h5 class="fw-bold mb-0">Pengaturan Treshold Data Telemetry</h5>
                        <p class="text-gray fs-7">Harap isi semua form input lalu klik tombol simpan.</p>
                        <div class="row">
                            <div class="col-6 col-md-8">
                                <p><a href="{{ route('create') }}" class="btn btn-primary btn-sm fw-bold">Tambah data</a>
                                </p>
                            </div>
                            <div class="col-6 col-md-4">
                                <div class="form-group">
                                    <select class="form-select" name="node" placeholder="Pilih Node" autocomplete="off">
                                        <option value="">Pilih Node</option>
                                        @foreach ($nodes as $serial_number)
                                            <option value="{{ $serial_number }}">{{ $serial_number }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        {{-- Error Validation --}}
                        <x-error-validation-message errors="$errors" />

                        {{-- Alert Message --}}
                        @if (session()->has('success'))
                            <div class="row">
                                <div class="col-md-12">
                                    <x-success-message action="{{ session()->get('success') }}" />
                                </div>
                            </div>
                        @endif

                        <form action="{{ route('tresholds.update') }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th rowspan="2">No</th>
                                            <th rowspan="2">IOT Node</th>
                                            <th rowspan="2">Sensor</th>
                                            <th rowspan="2">Value Min</th>
                                            <th rowspan="2">Value Max</th>
                                            <th rowspan="2">Kalibrasi</th>
                                            {{-- <th rowspan="2">Rules Engine</th> --}}
                                            <th rowspan="2">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tresholdData">
                                    </tbody>
                                </table>
                            </div>
                            <div class="form-group text-right">
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('select[name="node"]').change(function() {
                var selectedSerialNumber = $(this).val();

                if (selectedSerialNumber) {
                    var apiUrl = `${_base_url}/api/treshold/web?iot_node_serial_number=` + selectedSerialNumber;

                    $.ajax({
                        type: "GET",
                        url: apiUrl,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            if (response.status === "success" && Array.isArray(response.data) &&
                                response.data.length > 0) {
                                $("#tresholdData").empty();
                                response.data.forEach(function(item, index) {
                                    console.log(item)
                                    var row = "<tr>";
                                    row += "<td>" + (index + 1 || "") + "</td>";
                                    row += "<td>" + (item.iot_node_serial_number ||
                                        "") + "</td>";
                                    row += "<td>" + (item.variable || "") + "</td>";
                                    row += "<td>";
                                    row += "<input type='hidden' name='id[]' value='" +
                                        (item.id || "") + "'>";
                                    row +=
                                        "<input type='number' name='value_min[]' class='form-control' value='" +
                                        (item.value_min) + "'>";
                                    row += "</td>";
                                    row += "<td>";
                                    row +=
                                        "<input type='number' name='value_max[]' class='form-control' value='" +
                                        (item.value_max) + "'>";
                                    row += "</td>";
                                    row += "<td>";
                                    row +=
                                        "<input type='number' name='value[]' class='form-control' value='" +
                                        (item.value) + "'>";
                                    row += "</td>";
                                    // row += "<td>";
                                    // row +=
                                    //     "<select name='rules[]' id='rules' class='form-control'>";
                                    // row += "<option value='' " + (item.rules ? '' :
                                    //     'selected') + ">Rules</option>";
                                    // row += "<option value='>' " + (item.rules == '>' ?
                                    //     'selected' : '') + ">&gt;</option>";
                                    // row += "<option value='<' " + (item.rules == '<' ?
                                    //     'selected' : '') + ">&lt;</option>";
                                    // row += "<option value='>=' " + (item.rules == '>=' ?
                                    //     'selected' : '') + ">&gt;=</option>";
                                    // row += "<option value='<=' " + (item.rules == '<=' ?
                                    //     'selected' : '') + ">&lt;=</option>";
                                    // row += "</select>";
                                    // row += "</td>";
                                    row += "<td>";
                                    row += "<form id='Hapus" + item.id + "' action='" +
                                        '{{ route('tresholds.destroy', 'item.id') }}'
                                        .replace("item.id", item.id) +
                                        "' method='POST' class='d-inline-block'>";
                                    row +=
                                        "<input type='hidden' name='_token' value='" +
                                        $('meta[name="csrf-token"]').attr('content') +
                                        "'>";
                                    row +=
                                        "<input type='hidden' name='_method' value='DELETE'>";
                                    row +=
                                        "<button type='button' class='btn-link fw-bold' onclick='deleteActivity(" +
                                        item.id + ")'><small>Hapus</small></button>";
                                    row += "</form>";

                                    row += "</td>";
                                    row += "</tr>";

                                    $("#tresholdData").append(row);
                                });
                            } else {
                                $("#tresholdData").html(
                                    "<tr><td colspan='6'>- Tidak ada data ditemukan. -</td></tr>"
                                );
                            }
                        },
                        error: function(xhr, status, error) {
                            console.log("Error: " + error);
                        }
                    });
                }
            });
        });
    </script>
@endsection
