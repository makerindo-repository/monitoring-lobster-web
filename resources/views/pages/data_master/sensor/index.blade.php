@extends('pages.layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-9">
                <div class="card border-flat">
                    <div class="card-header bg-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="fw-bolder mb-0">Data Sensor</h5>
                                <p class="text-gray fs-7">Total {{ $data->count() }} data sensor yang ada di aplikasi.</p>
                            </div>
                            <div>
                                <a href="{{ route($route . 'create') }}" class="btn btn-primary btn-sm fw-bold">Tambah
                                    data</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">

                        {{-- Alert Message --}}
                        @if (session()->has('success'))
                            <div class="row">
                                <div class="col-md-12">
                                    <x-success-message action="{{ session()->get('success') }}" />
                                </div>
                            </div>
                        @endif

                        <div class="table-responsive">
                            <table class="table" style="font-size:.9em;">
                                <thead>
                                    <tr>
                                        <th width="1%" scope="col">No</th>
                                        <th scope="col">Sensor</th>
                                        <th scope="col">Rentang Nilai</th>
                                        <th scope="col">Kalibrasi</th>
                                        <th scope="col">Keterangan</th>
                                        <th scope="col">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($data as $row)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $row->namaSensor }}</td>
                                            <td>
                                                @if (!empty($row->rentangNilai))
                                                    {{ $row->rentangNilai }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td><input type="number" name="kalibrasi"></td>
                                            <td>
                                                @if (!empty($row->keterangan))
                                                    <span class="fw-bolder d-inline-block fs-7 ms-1" data-bs-toggle="modal"
                                                        data-bs-target="#modalDetail{{ $row->id }}"
                                                        style="color:#1e88e5; cursor: pointer;">Lihat Keterangan</span>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route($route . 'edit', $row->id) }}"
                                                    class="fw-bold mr-1">Edit</a>
                                                <form id="Hapus{{ $row->id }}"
                                                    action="{{ route($route . 'destroy', $row->id) }}" method="POST"
                                                    class="d-inline-block">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button id="Hapus" type="submit" class="btn-link fw-bold"
                                                        onclick="deleteActivity({{ $row->id }})">
                                                        Hapus
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                        <div class="modal fade" id="modalDetail{{ $row->id }}" tabindex="-1"
                                            aria-labelledby="modalDetailLabel" aria-hidden="true"
                                            style="font-size:.85em !important;">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-body tet-center">
                                                        <div class="row">
                                                            <h6 class="text-gray mb-2" id="keterangan{{ $row->id }}">
                                                                Keterangan {{ $row->namaSensor }}</h6>
                                                            <p>{{ $row->keterangan }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    @empty
                                        <p>- Tidak ada data ditemukan. -</p>
                                    @endforelse
                                </tbody>
                            </table>
                            {{ $data->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function Notif() {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Data yang memiliki anak tidak bisa dihapus!'
            });
        }

        @if (session()->has('Gagal'))
            Notif();
        @endif
    </script>
@endsection
