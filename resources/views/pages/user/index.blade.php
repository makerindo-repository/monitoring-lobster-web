@extends('pages.layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-9">
                <div class="card border-flat">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="fw-bolder mb-0">Data User</h5>
                                <p class="text-gray fs-7">Total {{ $data->count() }} data user yang ada di aplikasi.</p>
                            </div>
                            <div>
                                @if (auth()->user()->role == 'petugas')
                                    <a href="{{ route($route . 'create') }}" class="btn btn-primary btn-sm fw-bold">Tambah
                                        data</a>
                                @endif
                            </div>
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
                                        <th scope="col">No</th>
                                        <th scope="col">Nama</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Role</th>
                                        @if (auth()->user()->role == 'petugas')
                                            <th scope="col">Aksi</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $row)
                                        <tr>
                                            <td scope="row">{{ $loop->iteration }}</td>
                                            <td>{{ $row->name }}</td>
                                            <td>{{ $row->email }}</td>
                                            <td>{{ strtoupper($row->role) }}</td>
                                            <td>
                                                @if (auth()->user()->id !== $row->id && auth()->user()->role == 'petugas')
                                                    <a href="{{ route($route . 'edit', $row->id) }}"
                                                        class="fw-bold">Edit</a>
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
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="container">
        <div class="row justify-content-center">
            <div class="card border-flat">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="fw-bolder mb-0">Role Akses</h5>
                            <p class="text-gray fs-7">Hak Akses Pengguna.</p>
                        </div>
                        <div>
                            @if (auth()->user()->role == 'petugas')
                                <a href="{{ route('createPermission') }}" class="btn btn-primary btn-sm fw-bold">Tambah
                                    data</a>
                            @endif
                        </div>
                    </div>
                    {{-- Alert Message --}}
                    @if (session()->has('success'))
                        <div class="row">
                            <div class="col-md-12">
                                <x-success-message action="{{ session()->get('success') }}" />
                            </div>
                        </div>
                    @endif

                    <form action="{{ route('updatePermissions') }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="table-responsive">
                            <table class="table" style="font-size:.9em;">
                                <thead>
                                    <tr>
                                        <th rowspan="2">No</th>
                                        <th rowspan="2">Hak Akses</th>
                                        <th rowspan="2">Aksi</th>
                                        <th colspan="4" class="text-center">Role User</th>
                                    </tr>
                                    <tr align="center">
                                        <th>User</th>
                                        <th>Petugas</th>
                                        <th colspan="4">Direksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($permissions as $row)
                                        <tr>
                                            <td scope="row">{{ $loop->iteration }}</td>
                                            <td>
                                                {{ $row->name }}
                                            </td>
                                            <td>
                                                @if (auth()->user()->role == 'petugas')
                                                    <button class="btn-link fw-bold delete-button"
                                                        data-row-id="{{ $row->id }}">
                                                        Hapus
                                                    </button>
                                                @endif
                                            </td>

                                            <td align="center">
                                                @if (auth()->user()->role == 'petugas')
                                                    <input class="form-check-input" type="checkbox"
                                                        name="permissions[{{ $row->id }}][user]" value="1"
                                                        @if ($row->user) checked @endif>
                                                @else
                                                    <input class="form-check-input"
                                                        type="checkbox"name="permissions[{{ $row->id }}][user]"
                                                        value="1" @if ($row->user) checked @endif
                                                        disabled>
                                                @endif
                                            </td>
                                            <td align="center">
                                                @if (auth()->user()->role == 'petugas')
                                                    <input class="form-check-input" type="checkbox"
                                                        name="permissions[{{ $row->id }}][petugas]" value="1"
                                                        @if ($row->petugas) checked @endif>
                                                @else
                                                    <input class="form-check-input"
                                                        type="checkbox"name="permissions[{{ $row->id }}][petugas]"
                                                        value="1" @if ($row->petugas) checked @endif
                                                        disabled>
                                                @endif
                                            </td>
                                            <td align="center">
                                                @if (auth()->user()->role == 'petugas')
                                                    <input class="form-check-input" type="checkbox"
                                                        name="permissions[{{ $row->id }}][direksi]" value="1"
                                                        @if ($row->direksi) checked @endif>
                                                @else
                                                    <input class="form-check-input"
                                                        type="checkbox"name="permissions[{{ $row->id }}][direksi]"
                                                        value="1" @if ($row->direksi) checked @endif
                                                        disabled>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="form-group text-right">
                            @if (auth()->user()->role == 'petugas')
                                <button type="submit" class="btn btn-primary">Simpan </button>
                            @endif
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('click', function(e) {
            if (e.target && e.target.classList.contains('delete-button')) {
                e.preventDefault();

                const rowId = e.target.dataset.rowId;

                Swal.fire({
                    title: 'Apakah Anda Yakin Ingin Menghapus?',
                    text: 'Data Akan Terhapus!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#28a746',
                    cancelButtonColor: '#FF0000',
                    confirmButtonText: 'Hapus',
                    cancelButtonText: 'Batal',
                    reverseButtons: true,
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch(`{{ route('destroyPermission', '') }}/${rowId}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/json'
                            },
                        }).then(response => {
                            e.target.closest('tr').remove();
                        }).catch(error => {
                            console.error('Error:', error);
                            Swal.fire('Error', 'Terjadi kesalahan', 'error');
                        });
                    }
                });
            }
        });
    </script>
@endsection
