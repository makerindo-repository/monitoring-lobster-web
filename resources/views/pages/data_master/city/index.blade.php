@extends('pages.layouts.app')


@section('content')
<div class="container mb-5">
    <div class="row justify-content-center">
        <div class="col-md-9">
            <div class="card border-flat">
                <div class="card-header bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="fw-bolder mb-0">Data Kabupaten & Kota</h5>
                            <p class="text-gray fs-7">Total {{ $data->count() }} data yang ada di table.</p>
                        </div>
                        <div>
                            <a href="{{ route($route . 'create') }}" class="btn btn-primary btn-sm fw-bold">Tambah data</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">

                    {{-- Searching & Filtering --}}
                    <form id="form-filter" action="" method="GET">
                        <div class="row mt-2" style="font-size: .8em;">
                            <div class="col-md-6">
                                <div class="input-group mb-3">
                                    <input type="search" name="search" class="form-control border-flat" placeholder="Cari berdasarkan nama kabupaten atau kota" style="font-size:.95em;" value="{{ request('search') }}">
                                    <button class="btn btn-outline-secondary" type="submit">Cari</button>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <input type="hidden" name="region" value="{{ request('region') ?? 'all' }}">
                                <div class="dropdown">
                                    <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false" style="font-size:1em;">
                                        @if(request('region'))
                                            @if(request('region') == 'all')
                                            Semua Provinsi
                                            @else
                                            {{ request('region') }}
                                            @endif
                                        @else
                                        Semua Pronvinsi
                                        @endif
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-filter border shadow" aria-labelledby="dropdownMenuButton1" style="font-size:1em;max-height: 200px;overflow-y: scroll;">
                                    <li><a class="dropdown-item" data-region="all" href="#" >Semua Provinsi</a></li>
                                    @foreach ($regions as $id => $name)
                                        <li><a class="dropdown-item" data-region="{{ $name }}" href="#">{{ $name }}</a></li>
                                    @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </form>

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
                                <th scope="col">Nama</th>
                                <th class="text-center" scope="col">Pronvinsi</th>
                                <th scope="col"></th>
                              </tr>
                            </thead>
                            <tbody>
                                @forelse ($data as $row)
                                <tr>
                                    <td>{{ $loop->iteration + $data->firstItem() - 1 }}</td>
                                    <td>{{ $row->name }}</td>
                                    <td class="text-center">{{ $row->region ? $row->region->name : '[N/A]' }}</td>
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
                    </div>

                    <div class="row">
                        <div class="col-md-12" style="font-size:.85em;">
                            {{ $data->appends(request()->input())->links() }}
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
    window.onload = function () {
        document.querySelectorAll('.dropdown-menu-filter li a')
            .forEach(el => {
                el.addEventListener('click', function (e) {
                    document.querySelector('[name="region"]').value = this.getAttribute('data-region');
                    document.getElementById('form-filter').submit();

                    e.preventDefault();
                });
            });
    }
</script>
@endpush
