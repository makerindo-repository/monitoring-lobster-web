@extends('pages.layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-9">
            <div class="card border-flat">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="fw-bolder mb-0">Log Activity</h5>
                            <p class="text-gray fs-7">Daftar Riwayat aktivitas pada menu Edge Computing.</p>
                        </div>
                        <div>
                            <a href="" class="btn btn-success btn-sm fw-bold">Kembali ke halaman utama</a>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table" style="font-size:.9em;">
                            <thead>
                              <tr>
                                <th scope="col">No</th>
                                <th scope="col">Log</th>
                                <th scope="col">User</th>
                                <th scope="col">Waktu</th>
                              </tr>
                            </thead>
                            <tbody>
                               
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection