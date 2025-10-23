@extends('pages.layouts.app')

@push('style')
<style>
    .dot-active {
        background-color: rgba(40,199,111,.12);
        color: #28C76F!important;
        font-size: 1em;
    }

    #riwayat-maintenance a{
        text-decoration: none;
    }

</style>
@endpush

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-3">
                    <div class="card" style="background: #1a6ab0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h2 class="fw-bold text-white">
                                        {{ $statistic['edge'] }}
                                        <small style="font-size:.5em; font-weight:normal;">unit</small>
                                    </h2>
                                </div>
                                <div class="col-md-6">
                                    <h2 class="fw-bold text-white">
                                        1
                                        <small style="font-size:.5em; font-weight:normal;">Aktif</small>
                                    </h2>
                                </div>
                            </div>
                            <small class="text-white">Total Edge Computing</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-primary">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h2 class="fw-bold text-white">
                                        {{ $statistic['node'] }}
                                        <small style="font-size:.5em; font-weight:normal;">unit</small>
                                    </h2>
                                </div>
                                <div class="col-md-6">
                                    <h2 class="fw-bold text-white">
                                        {{ $statistic['node_active'] }}
                                        <small style="font-size:.5em; font-weight:normal;">Aktif</small>
                                    </h2>
                                </div>
                            </div>
                            <small class="text-white">Total IoT Node</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-primary">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h2 class="fw-bold text-white">
                                        {{ $statistic['region_count'] }}
                                        <small style="font-size:.5em; font-weight:normal;">Prov</small>
                                    </h2>
                                </div>
                                <div class="col-md-6">
                                    <h2 class="fw-bold text-white">
                                        {{ $statistic['city_count'] }}
                                        <small style="font-size:.5em; font-weight:normal;">Kota</small>
                                    </h2>
                                </div>
                            </div>
                            <small class="text-white">Total Terdata</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-primary">
                        <div class="card-body">
                            <h2 class="fw-bold text-white">
                                {{ $statistic['client'] }}
                                <small style="font-size:.5em; font-weight:normal;">data</small>
                            </h2>
                            <small class="text-white">Total Client</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-7">
            <div class="card card-flat">
                <div class="card-body">
                    <div>
                        <h5 class="fw-bolder mb-0">Data IoT Node Aktif</h5>
                        <p class="text-gray fs-7">Daftar IoT Node yang aktif hari ini</p>
                    </div>
                    <div class="table-responsive">
                        <table class="table fs-7">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nomor Serial IoT</th>
                                    <th>Wilayah</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($region_node_active as $i => $row)
                                <tr>
                                    <td>{{ $i + 1 }}</td>
                                    <td>{{ $row->serial_number }}</td>
                                    <td>{{ $row->edge_computing->city ? $row->edge_computing->city->name : 'undefined' }}, {{ $row->edge_computing->city && $row->edge_computing->city->region ? $row->edge_computing->city->region->name : 'undefined'}}</td>
                                    <td>
                                        <div class="badge dot-active">
                                            Aktif
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-body">
                    <h5 class="fw-bolder mb-0">Riwayat Registrasi IoT Node</h5>
                    <p class="text-gray fs-7">Daftar Riwayat Registrasi IoT Node terakhir</p>
                    <div id="heatmap">
                        <table class="table fs-7">
                            <thead>
                                <tr>
                                    <th>Nomor Serial IoT</th>
                                    <th>Lokasi</th>
                                    <th>Tanggal</th>
                                    <th>Oleh</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($registration_history as $row)
                                <tr>
                                    <td>{{ $row->serial_number }}</td>
                                    <td>{{ $row->edge_computing->city ? $row->edge_computing->city->name : 'undefined' }}, {{ $row->edge_computing->city && $row->edge_computing->city->region ? $row->edge_computing->city->region->name : 'undefined'}}</td>
                                    <td>{{ $row->activated_at }}</td>
                                    <td>{{ ($row->user ? $row->user->name : '') }}</td>
                                </tr> 
                                @empty
                                    - Tidak ada data ditemukan. -
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-md-5">
            
            <div class="card card-flat">
                <div class="card-body">
                    <div>
                        <h5 class="fw-bolder mb-0">Data Treshold Tertinggi</h5>
                        <p class="text-gray fs-7">Data Treshold wilayah Tertinggi</p>
                    </div>
                    <div class="table-responsive">
                        <table class="table fs-7">
                            <tr>
                                <td>
                                    pH Tertinggi
                                </td>
                                <td>:</td>
                                <td class="text-danger fw-bold">
                                    <div>ED010122011NODE001</div>
                                    <div>Kota Bandung, Jawa Barat</div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    COD Tertinggi
                                </td>
                                <td>:</td>
                                <td class="text-danger fw-bold">
                                    <div>ED010122011NODE001</div>
                                    <div>Kota Bandung, Jawa Barat</div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    TSS Tertinggi
                                </td>
                                <td>:</td>
                                <td class="text-danger fw-bold">
                                    <div>ED010122011NODE001</div>
                                    <div>Kota Bandung, Jawa Barat</div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Ammonia Tertinggi
                                </td>
                                <td>:</td>
                                <td class="text-danger fw-bold">
                                    <div>ED010122011NODE001</div>
                                    <div>Kota Bandung, Jawa Barat</div>
                                </td>
                            </tr>
                            
                        </table>
                    </div>
                </div>
            </div>

            <div class="card card-flat mt-4" id="riwayat-maintenance">
                <div class="card-body">
                    <div>
                        <h5 class="fw-bolder mb-0">Riwayat Maintenance IoT Node</h5>
                        <p class="text-gray fs-7">Daftar Riwayat Maintenance IoT Node terakhir</p>
                    </div>
                    <div class="fs-7">
                        @foreach($maintenance_history as $row)
                        <div class="mt-3">
                            <a href="{{ route('iot-node.show', $row->iot_node_id) }}">
                                <div class="box shadow border p-2">
                                    <h6 style="color: #1e88e5;">{{ $row->description }}</h6>
                                    <div>
                                        <div class="row">
                                            <div class="col-md-7 text-gray">
                                                <div class="fw-bold">{{ $row->iot_node ? $row->iot_node->serial_number : '-' }}</div>
                                                <div>Kota Bandung, Jawa Barat</div>
                                            </div>
                                            <div class="col-md-5 text-gray">
                                                {{ $row->created_at }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>


        </div>
    </div>


</div>
<br><br><br>
@endsection