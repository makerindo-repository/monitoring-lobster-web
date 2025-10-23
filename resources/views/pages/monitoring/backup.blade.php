@extends('pages.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card border-flat">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="fw-bolder mb-0">Daftar IOT Nodes</h5>
                            <p class="text-gray fs-7">Total data user yang ada di aplikasi.</p>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table" style="font-size:.9em;">
                            <thead>
                              <tr>
                                <th scope="col">No</th>
                                <th scope="col">IOT Node</th>
                                <th scope="col">Edge Computing</th>
                                <th scope="col">Lokasi</th>
                                <th scope="col">Status</th>
                                <th scope="col"></th>
                              </tr>
                            </thead>
                            <tbody>
                                @forelse ($data as $row)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <h6 class="fw-bolder">
                                            <img src="{{ asset('svg/icon/hard-drive.svg') }}" alt="ic" width="18px">
                                            {{ $row->serial_number }}
                                        </h6>
                                    </td>
                                    <td class="text-gray">{{ $row->edge_computing->serial_number }}</a> - Node {{ $row->edge_computing_node }}</td>
                                    <td class="text-gray">
                                        <img src="{{ asset('svg/icon/map-pin.svg') }}" alt="ic" width="15px">
                                        {{ $row->city ? $row->city->name : 'undefined' }}, {{ $row->city && $row->city->region ? $row->city->region->name : 'undefined'}}</td>
                                    <td>
                                        @if($row->activated_by)
                                        <span class="badge bg-success">Aktif</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($row->activated_by)
                                        <a href="" class="btn btn-primary btn-sm fw-bold" style="font-size:.9em !important;">Monitor</a>
                                        @else
                                        <button type="button" class="btn btn-secondary btn-sm fw-bold" disabled style="font-size:.9em !important;">Monitor</button>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6">- Tidak ada data IOT yang aktif. -</td>
                                </tr>
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
