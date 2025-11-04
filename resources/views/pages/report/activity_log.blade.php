@extends('pages.layouts.app')

@section('content')
    <div class="container">
        <h4 class="fw-bolder mb-0">Laporan Log Aktivitas</h4>
        <p class="text-gray fs-7 mb-4">Riwayat Aktivitas Pengguna</p>

        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card border-flat">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="w-25">
                                <form action="" method="GET" id="form-filter">
                                    <div>
                                        <input type="date" name="date" class="form-control border-2 rounded-3"
                                            style="background-color: #F4F4F4;"
                                            onchange="document.querySelector('#form-filter').submit()"
                                            value="{{ request('date') }}">
                                    </div>
                                </form>
                            </div>
                            <div>
                                <div class="dropdown">
                                    <button class="btn btn-sm fw-bold text-white rounded-3 px-3"
                                        style="background-color: #FB9E3A;" type="button" id="dropdownMenuButton1"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        Export <i class="fa-solid fa-file-export ms-1"></i>
                                    </button>
                                    <ul class="dropdown-menu shadow" aria-labelledby="dropdownMenuButton1">
                                        <li><a class="dropdown-item" href="{{ route('report.activityLog.pdf') }}"
                                                target="_blank">PDF</a></li>
                                        <li><a class="dropdown-item" href="{{ route('report.activityLog.excel') }}"
                                                target="_blank">Excel</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="row">
                                <div class="col-md-3">

                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table fs-7 mt-3">
                                <thead>
                                    <tr>
                                        <th>Nomor</th>
                                        <th>Waktu</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($data as $row)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $row->waktu }}</td>
                                            <td>
                                                Pengguna {{ $row->user->name }} Berhasil
                                                <span
                                                    class="badge rounded-pill {{ $row->status == 'Login.' ? 'bg-success' : 'bg-danger' }}">
                                                    {{ $row->status == 'Login.' ? 'Login' : 'Logout' }}
                                                </span>
                                            </td>

                                        </tr>
                                    @empty
                                        -tidak ada data-, <a href="{{ route('report.activityLog') }}"
                                            style="color: #1e88e5;">segarkan kembali</a>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
