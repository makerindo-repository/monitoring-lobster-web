@extends('pages.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card border-flat">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="fw-bolder mb-0">Laporan Log Aktivitas</h5>
                            <p class="text-gray fs-7">Riwayat Aktivitas Pengguna</p>
                        </div>
                        <div>
                            <div class="dropdown">
                                <button class="btn btn-primary btn-sm fw-bold" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                    Export
                                </button>
                                <ul class="dropdown-menu shadow" aria-labelledby="dropdownMenuButton1">
                                  <li><a class="dropdown-item" href="{{ route('report.activityLog.pdf') }}" target="_blank">PDF</a></li>
                                  <li><a class="dropdown-item" href="{{ route('report.activityLog.excel') }}" target="_blank">Excel</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="row">
                            <div class="col-md-3">
                                <form action="" method="GET" id="form-filter">
                                    <div class="row">
                                        <div class="col">
                                            <input type="date" name="date" class="form-control" onchange="document.querySelector('#form-filter').submit()" value="{{ request('date') }}">
                                        </div>
                                    </div>
                                </form>
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
                                <td>{{$loop->iteration}}</td>
                                <td>{{ $row->waktu }}</td>
                                <td>
                                    Pengguna {{ $row->user->name }} Berhasil
                                    <span class="badge rounded-pill {{ $row->status == 'Login.' ? 'bg-success' : 'bg-danger' }}">
                                        {{ $row->status == 'Login.' ? 'Login' : 'Logout' }}
                                    </span>
                                </td>

                            </tr>
                          @empty
                          -tidak ada data-, <a href="{{ route('report.activityLog') }}" style="color: #1e88e5;">segarkan kembali</a>
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

