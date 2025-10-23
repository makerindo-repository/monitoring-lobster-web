@php
    $message = [
        'store'   => 'Berhasil menambahkan data.',
        'update'  => 'Berhasil mengedit data.',
        'destroy' => 'Berhasil menghapus data.'
    ][$action] ?? '';
@endphp
<div class="alert alert-success">
    <div class="fw-bold fs-7">{{ $message }}</div>
</div>