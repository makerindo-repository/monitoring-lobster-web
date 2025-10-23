@extends('pages.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card border-flat">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="fw-bolder mb-0">Laporan Data Registrasi</h5>
                            <p class="text-gray fs-7">Registrasi IoT Node</p>
                        </div>
                        <div>
                            <div class="dropdown">
                                <button class="btn btn-primary btn-sm fw-bold" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                    Export
                                </button>
                                <ul class="dropdown-menu shadow" aria-labelledby="dropdownMenuButton1">
                                  <li><a class="dropdown-item" href="{{ route('report.nodeRegistration.pdf') }}" target="_blank">PDF</a></li>
                                  <li><a class="dropdown-item" href="{{ route('report.nodeRegistration.excel') }}" target="_blank">Excel</a></li>
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
                                <th>Nomor Serial</th>
                                <th>Edge Computing</th>
                                <th>Waktu</th>
                                <th>Oleh</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($data as $row)
                               <tr>
                                   <td>{{ $row->serial_number }}</td>
                                   <td>{{ $row->edge_computing->serial_number }} | Node - {{ $row->edge_computing_node }}</td>
                                   <td>{{ $row->activated_at }}</td>
                                   <td>{{ $row->user ? $row->user->name : '' }}</td>
                               </tr>
                            @empty
                            -tidak ada data-, <a href="{{ route('report.nodeRegistration') }}" style="color: #1e88e5;">segarkan kembali</a>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                    {{ $data->links() }}
                </div>
            </div>
        </div>

    </div>
</div>

@endsection
