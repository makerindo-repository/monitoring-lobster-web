@extends('pages.layouts.app')


@section('content')
    <div class="container">
        <h4 class="fw-bolder mb-0">Data Pakan</h4>
        <p class="text-gray fs-7">Total {{ $data->count() }} data pakan yang ada di aplikasi.</p>

        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card p-4 gap-4">
                    <div class="w-100 text-end">
                        <a href="{{ route($route . 'create') }}" class="btn btn-sm fw-bolder text-white"
                            style="background-color: #FB9E3A;">Tambah
                            data <i class="fa-solid fa-circle-plus ms-1"></i></a>
                    </div>

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
                                    <th scope="col" class="text-center">Pemberian Ke</th>
                                    <th scope="col" class="text-center">Jenis Pakan</th>
                                    <th scope="col" class="text-center">Berat (kg)</th>
                                    <th scope="col" class="text-center">Petugas</th>
                                    <th scope="col" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($data as $row)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td class="text-center">{{ $row->pemberian_ke }}</td>
                                        <td class="text-center">{{ $row->jenis_pakan }}</td>
                                        <td class="text-center">{{ $row->berat }}</td>
                                        <td class="text-center">{{ $row->petugas->nama }}</td>
                                        <td class="text-center">
                                            <a href="{{ route($route . 'edit', $row->id) }}"
                                                class="fw-bold mr-1 rounded text-white"
                                                style="background-color: #FB9E3A; padding: 0.35rem;"><i
                                                    class="fa-solid fa-pen-to-square"></i></a>
                                            <form id="Hapus{{ $row->id }}"
                                                action="{{ route($route . 'destroy', $row->id) }}" method="POST"
                                                class="d-inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button id="Hapus" type="submit"
                                                    class="bg-danger fw-bold border-0 rounded text-white"
                                                    style="padding-block: 0.25rem;"
                                                    onclick="deleteActivity({{ $row->id }})">
                                                    <i class="fa-solid fa-trash-arrow-up"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">- Tidak ada data ditemukan. -</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="text-center">
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
