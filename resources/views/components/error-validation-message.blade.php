@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0 fw-bold fs-7">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif