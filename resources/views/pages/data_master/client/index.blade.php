@extends('pages.layouts.app')


@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-9">
            <div class="card border-flat">
                <div class="card-header bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="fw-bolder mb-0">Data Client</h5>
                            <p class="text-gray fs-7">Total {{ $data->count() }} data client yang ada di aplikasi.</p>
                        </div>
                        <div>
                            <a href="{{ route($route . 'create') }}" class="btn btn-primary btn-sm fw-bold">Tambah data</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">

                    {{-- Alert Message --}}
                    @if(session()->has('success'))
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
                                <th scope="col">Nama Client</th>
                                <th scope="col">Keterangan</th>
                                <th scope="col"></th>
                              </tr>
                            </thead>
                            <tbody>
                                @forelse ($data as $row)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $row->name }}</td>
                                    <td>{{ $row->description }}</td>
                                    <td>
                                        <a href="{{ route($route . 'edit', $row->id) }}" class="fw-bold mr-1">Edit</a>
                                        <form id="Hapus{{ $row->id }}" action="{{ route($route . 'destroy', $row->id) }}" method="POST" class="d-inline-block" >
                                            @csrf
                                            @method('DELETE')
                                            <button id="Hapus" type="submit" class="btn-link fw-bold" onclick="deleteActivity({{$row->id}})">
                                                Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
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
@endsection
