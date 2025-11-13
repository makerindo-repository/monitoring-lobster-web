@extends('pages.layouts.app')

@push('style')
    <style>
        .dot-active {
            background-color: rgba(40, 199, 111, .12);
            color: #28C76F !important;
            font-size: 1em;
        }

        #riwayat-maintenance a {
            text-decoration: none;
        }

        .custom-progress {
            height: 100% !important;
            flex-direction: column-reverse !important;
        }

        .custom-progress-bar {
            transition: height 0.6s ease !important;
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.0.1/dist/css/tom-select.css" rel="stylesheet">
@endpush

@section('content')
    <div class="container">
        <h4 class="fw-bold mb-4">Dashboard</h4>

        <div class="row">
            {{-- Summary Data --}}
            <div class="col-md-9">
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="row g-2">
                                    <small class="text-secondary">Total Edge Computing</small>
                                    <div class="col-md-6">
                                        <h2 class="fw-bold">
                                            {{ $statistic['edge'] }}
                                            <small style="font-size:.5em; font-weight:normal;">unit</small>
                                        </h2>
                                    </div>
                                    <div class="col-md-6 text-end">
                                        <i class="rounded-circle p-3 fs-5 fa-solid fa-server my-auto"
                                            style="color: #FB9E3A; background-color: rgba(251, 158, 58, 0.3);"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="row g-2">
                                    <small class="text-secondary">Total IoT Node</small>
                                    <div class="col-md-6">
                                        <h2 class="fw-bold">
                                            {{ $statistic['node'] }}
                                            <small style="font-size:.5em; font-weight:normal;">unit</small>
                                        </h2>
                                    </div>
                                    <div class="col-md-6 text-end">
                                        <i class="rounded-circle p-3 fs-5 fa-solid fa-microchip my-auto"
                                            style="color: #3A3DFB; background-color: rgba(58, 61, 251, 0.3);"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="row g-2">
                                    <small class="text-secondary">Total Keramba Jaring Apung (KJA)</small>
                                    <div class="col-md-6">
                                        <h2 class="fw-bold">
                                            {{ $statistic['kja'] }}
                                            <small style="font-size:.5em; font-weight:normal;">KJA</small>
                                        </h2>
                                    </div>
                                    <div class="col-md-6 text-end">
                                        <i class="rounded-circle p-3 fs-5 fa-solid fa-border-all my-auto"
                                            style="color: #ff3fcf; background-color: rgba(255, 63, 207, 0.3)"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="row g-2">
                                    <small class="text-secondary">Total Lobster</small>
                                    <div class="col-md-6">
                                        <h2 class="fw-bold">
                                            10
                                            <small style="font-size:.5em; font-weight:normal;">Ekor</small>
                                        </h2>
                                    </div>
                                    <div class="col-md-6 text-end">
                                        <i class="rounded-circle p-3 fs-5 fa-solid fa-shrimp my-auto"
                                            style="color: #d00000; background-color: rgb(208, 0, 0, 0.3)"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="row g-2">
                                    <small class="text-secondary">Total Kamera Aktif</small>
                                    <div class="col-md-6">
                                        <h2 class="fw-bold">
                                            {{ $statistic['camera_active'] }}
                                            <small style="font-size:.5em; font-weight:normal;">Kamera</small>
                                        </h2>
                                    </div>
                                    <div class="col-md-6 text-end">
                                        <i class="rounded-circle p-3 fs-5 fa-solid fa-camera my-auto"
                                            style="color: #d00000; background-color: rgb(208, 0, 0, 0.3)"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Cuaca Terkini dari BMKG --}}
            <div class="col-md-3">
                <div class="card p-3 gap-4">
                    <h6 class="fw-semibold text-secondary mb-1">Cuaca Terkini</h6>
                    <h6 class="text-muted small mb-2">
                        <i class="fa-solid fa-location-dot text-primary me-1"></i>
                        {{ $weather->desa . ', ' . $weather->kabupaten_kota . ', ' . $weather->provinsi }}
                    </h6>

                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="h2 fw-bold mb-0 text-dark">
                                {{ $weather->temperature }}°C
                            </p>
                            <p class="small text-muted mb-0">Suhu</p>
                        </div>
                        <div>
                            @if ($weather->image != null)
                                <img src="{{ $weather->image }}" alt="Cuaca" class="img-fluid"
                                    style="width: 48px; height: 48px;">
                            @else
                                <i class="fas fa-question-circle text-secondary fs-2"></i>
                            @endif
                        </div>
                    </div>

                    <div class="row text-center mt-3 small text-muted">
                        <div class="col d-flex flex-column align-items-center">
                            <i class="fas fa-wind text-secondary mb-1"></i>
                            {{ $weather->wind_speed }} km/h</span>
                        </div>
                        <div class="col d-flex flex-column align-items-center">
                            <i class="fas fa-tint text-primary mb-1"></i>
                            <span>{{ $weather->humidity }} %</span>
                        </div>
                        <div class="col d-flex flex-column align-items-center">
                            <i class="fas fa-cloud-rain text-info mb-1"></i>
                            <span>{{ $weather->rainfall }} mm</span>
                        </div>
                    </div>

                    <p class="text-center small text-muted mt-2 mb-0">
                        {{ $weather->description }}
                    </p>
                </div>
            </div>
        </div>

        <div class="card p-3 gap-4 mt-4">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="fw-bold">Kamera Real-Time</h4>
                <span class="fw-bolder text-secondary">Terakhir diupdate:
                    {{ $latest_telemetry->created_at->format('d-m-Y H:i:s') }}</span>
            </div>

            {{-- Dropdown select camera --}}
            <div>
                <form action="" method="post">
                    @csrf
                    <label for="camera" class="form-label fw-bolder">Pilih Kamera</label>
                    <select name="camera" id="camera" class="form-select w-50">
                        @foreach ($cameras as $cam)
                            <option value="{{ $cam->id_kamera }}">{{ $cam->id_kamera }}</option>
                        @endforeach
                    </select>
                </form>
            </div>

            <div class="row">
                <div class="col-md-9">
                    <div class="row g-3">
                        <div class="col-12">
                            <div class="w-100">
                                <img src="{{ asset('images/dummy-camera.png') }}" alt="Real-Time Capture" class="w-100"
                                    style="object-fit: contain;">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="card px-2 py-3 border-2 gap-3">
                                <div>
                                    <h5 class="fw-bolder"><i class="fa-solid fa-location-crosshairs me-2"
                                            style="color: #FB9E3A;"></i>Pemantauan Aktivitas Lobster dengan AI (Berdasarkan
                                        Data Kamera)</h5>
                                </div>
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <div class="card p-2" style="background-color: #f1f1f1;">
                                            <p class="m-0">Sedang Makan</p>
                                            <p class="mt-1 fw-bolder fs-5" style="color: #FB9E3A;">50%</p>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card p-2" style="background-color: #f1f1f1;">
                                            <p class="m-0">Sedang Tidur</p>
                                            <p class="mt-1 fw-bolder fs-5 text-success">35%</p>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card p-2" style="background-color: #f1f1f1;">
                                            <p class="m-0">Sedang Berantem</p>
                                            <p class="mt-1 fw-bolder fs-5" style="color: #3a3afb">15%</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card px-2 py-3 border-2 gap-2">
                        <div>
                            <h6 class="fw-bolder"><i class="fa-solid fa-location-crosshairs me-2"
                                    style="color: #FB9E3A;"></i>Lokasi dan Posisi KJA</h6>

                            <div class="row">
                                <div class="col-md-6">
                                    <p class="m-0 text-secondary fs-7">Longitude</p>
                                    <p class="fw-bolder fs-7">{{ (float) $latest_telemetry->longitude }}&deg;</p>
                                </div>
                                <div class="col-md-6">
                                    <p class="m-0 text-secondary fs-7">Latitude</p>
                                    <p class="fw-bolder fs-7">{{ (float) $latest_telemetry->latitude }}&deg;</p>
                                </div>
                                <div class="col-md-6">
                                    <p class="m-0 text-secondary fs-7">Altitude</p>
                                    <p class="fw-bolder fs-7">{{ (float) $latest_telemetry->altitude }}m</p>
                                </div>
                                <div class="col-md-6">
                                    <p class="m-0 text-secondary fs-7">Pitch</p>
                                    <p class="fw-bolder fs-7">{{ (float) $latest_telemetry->pitch }}&deg;</p>
                                </div>
                                <div class="col-md-6">
                                    <p class="m-0 text-secondary fs-7">Roll</p>
                                    <p class="fw-bolder fs-7">{{ (float) $latest_telemetry->roll }}&deg;</p>
                                </div>
                                <div class="col-md-6">
                                    <p class="m-0 text-secondary fs-7">Yaw</p>
                                    <p class="fw-bolder fs-7">{{ (float) $latest_telemetry->yaw }}&deg;</p>
                                </div>
                            </div>
                        </div>

                        <div>
                            <h6 class="fw-bolder"><i class="fa-solid fa-location-crosshairs me-2"
                                    style="color: #FB9E3A;"></i>Parameter Lingkungan</h6>

                            <div class="row">
                                <div class="col-md-6">
                                    <p class="m-0 text-secondary fs-7">Temperature</p>
                                    <p class="fw-bolder fs-7">{{ $latest_telemetry->suhu }}&deg;C</p>
                                </div>
                                <div class="col-md-6">
                                    <p class="m-0 text-secondary fs-7">Humidity</p>
                                    <p class="fw-bolder fs-7">{{ $latest_telemetry->kelembapan }}%RH</p>
                                </div>
                                <div class="col-md-6">
                                    <p class="m-0 text-secondary fs-7">Pressure</p>
                                    <p class="fw-bolder fs-7">{{ $latest_telemetry->pressure }}hPa</p>
                                </div>
                            </div>
                        </div>

                        <div>
                            <h6 class="fw-bolder"><i class="fa-solid fa-location-crosshairs me-2"
                                    style="color: #FB9E3A;"></i>Sensor Kualitas Air</h6>

                            <div class="row">
                                <div class="col-md-6">
                                    <p class="m-0 text-secondary fs-7">Temperature</p>
                                    <p class="fw-bolder fs-7">{{ $latest_telemetry->suhu_air }}&deg;C</p>
                                </div>
                                <div class="col-md-6">
                                    <p class="m-0 text-secondary fs-7">Dissolved Oxygen</p>
                                    <p class="fw-bolder fs-7">{{ $latest_telemetry->dissolved_oxygen }}mg/L</p>
                                </div>
                                <div class="col-md-6">
                                    <p class="m-0 text-secondary fs-7">pH</p>
                                    <p class="fw-bolder fs-7">{{ $latest_telemetry->ph }}pH</p>
                                </div>
                                <div class="col-md-6">
                                    <p class="m-0 text-secondary fs-7">Turbidity</p>
                                    <p class="fw-bolder fs-7">{{ $latest_telemetry->turbidity }}NTU</p>
                                </div>
                                <div class="col-md-6">
                                    <p class="m-0 text-secondary fs-7">Salinity</p>
                                    <p class="fw-bolder fs-7">{{ $latest_telemetry->salinity }}PSU</p>
                                </div>
                                <div class="col-md-6">
                                    <p class="m-0 text-secondary fs-7">Current Speed</p>
                                    <p class="fw-bolder fs-7">{{ $latest_telemetry->arus }}m/s</p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                {{-- <div class="row g-3">
                        <div class="col-12">
                            <div class="card px-2 py-3 border-2 gap-3">
                                <div>
                                    <h5 class="fw-bolder"><i class="fa-solid fa-location-crosshairs me-2"
                                            style="color: #FB9E3A;"></i>Lokasi dan Posisi KJA</h5>
                                </div>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="card p-2" style="background-color: #f1f1f1;">
                                            <p class="m-0">Longitude</p>
                                            <p class="mt-1 fw-bolder fs-5" style="color: #FB9E3A;">107.589234&deg;</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card p-2" style="background-color: #f1f1f1;">
                                            <p class="m-0">Latitude</p>
                                            <p class="mt-1 fw-bolder fs-5" style="color: #FB9E3A;">-6.872345&deg;</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card p-2" style="background-color: #f1f1f1;">
                                            <p class="m-0">Altitude</p>
                                            <p class="mt-1 text-success fw-bolder fs-5">0m</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card p-2" style="background-color: #f1f1f1;">
                                            <p class="m-0">Pitch</p>
                                            <p class="mt-1 text-success fw-bolder fs-5">5.23&deg;</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card p-2" style="background-color: #f1f1f1;">
                                            <p class="m-0">Roll</p>
                                            <p class="mt-1 fw-bolder fs-5" style="color: #3a3afb;">-2.87&deg;</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card p-2" style="background-color: #f1f1f1;">
                                            <p class="m-0">Yaw</p>
                                            <p class="mt-1 fw-bolder fs-5" style="color: #3a3afb;">180.45&deg;</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="card px-2 py-3 border-2 gap-3">
                                <div>
                                    <h5 class="fw-bolder"><i class="fa-solid fa-location-crosshairs me-2"
                                            style="color: #FB9E3A;"></i>Parameter Lingkungan</h5>
                                </div>
                                <div class="row g-3">
                                    <div class="col-12">
                                        <div class="card p-2" style="background-color: #f1f1f1;">
                                            <p class="m-0">Temperature</p>
                                            <p class="mt-1 fw-bolder fs-5" style="color: #FB9E3A;">28.6&deg;C</p>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="card p-2" style="background-color: #f1f1f1;">
                                            <p class="m-0">Humidity</p>
                                            <p class="mt-1 fw-bolder fs-5 text-success">75%RH</p>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="card p-2" style="background-color: #f1f1f1;">
                                            <p class="m-0">Pressure</p>
                                            <p class="mt-1 fw-bolder fs-5" style="color: #3a3afb">1008.3hPa</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="card px-2 py-3 border-2 gap-3">
                                <div>
                                    <h5 class="fw-bolder"><i class="fa-solid fa-location-crosshairs me-2"
                                            style="color: #FB9E3A;"></i>Sensor
                                        Kualitas Air</h5>
                                </div>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="card p-2" style="background-color: #f1f1f1;">
                                            <p class="m-0">Temperature</p>
                                            <p class="mt-1 fw-bolder fs-5" style="color: #FB9E3A;">26.4&deg;C</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card p-2" style="background-color: #f1f1f1;">
                                            <p class="m-0">Dissolved Oxygen</p>
                                            <p class="mt-1 fw-bolder fs-5" style="color: #FB9E3A;">7.8mg/L</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card p-2" style="background-color: #f1f1f1;">
                                            <p class="m-0">pH</p>
                                            <p class="mt-1 fw-bolder fs-5 text-success">7.2pH</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card p-2" style="background-color: #f1f1f1;">
                                            <p class="m-0">Turbidity</p>
                                            <p class="mt-1 fw-bolder fs-5 text-success">12.5NTU</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card p-2" style="background-color: #f1f1f1;">
                                            <p class="m-0">Salinity</p>
                                            <p class="mt-1 fw-bolder fs-5" style="color: #3a3afb">31.8PSU</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card p-2" style="background-color: #f1f1f1;">
                                            <p class="m-0">Current Speed</p>
                                            <p class="mt-1 fw-bolder fs-5" style="color: #3a3afb">0.45m/s</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> --}}
            </div>
        </div>

        <div class="card p-3 mt-4 gap-4">
            <h4 class="fw-bold">Log Pemberian Pakan</h4>
            <div class="table-responsive">
                <table class="table" style="font-size:.9em;">
                    <thead>
                        <tr>
                            <th scope="col" class="text-center">Timestamp</th>
                            <th scope="col" class="text-center">Jenis Pakan</th>
                            <th scope="col" class="text-center">Berat (Kg)</th>
                            <th scope="col" class="text-center">Petugas</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($logPakan as $row)
                            <tr>
                                <td class="text-center">{{ $row->created_at }}</td>
                                <td class="text-center">{{ $row->jenis_pakan }}</td>
                                <td class="text-center">{{ $row->berat }}</td>
                                <td class="text-center">{{ $row->petugas->nama }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">- Tidak ada data ditemukan. -</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="text-center">
                    {{ $logPakan->links() }}
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection

@push('footer')
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/phAir.js') }}"></script>
    <script src="{{ asset('js/CodSensor.js') }}"></script>
    <script src="{{ asset('js/NitratSensor.js') }}"></script>
    <script src="{{ asset('js/TssSensor.js') }}"></script>
    <script src="{{ asset('js/DissolvedOxygen.js') }}"></script>
    <script src="{{ asset('js/ArusAir.js') }}"></script>
    <script src="{{ asset('js/Turbidity.js') }}"></script>
    <script src="{{ asset('js/Salinity.js') }}"></script>
    <script src="{{ asset('js/OrpSensor.js') }}"></script>
    <script src="{{ asset('js/TdsSensor.js') }}"></script>
    <script src="{{ asset('js/temperatureAir.js') }}"></script>
    <script src="{{ asset('js/TinggiAir.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endpush

@push('script')
    <script>
        const sensors = [
            'dissolver-oxygen',
            'turbidity',
            'salinity',
            'cod',
            'ph',
            'orp',
            'tds',
            'nitrat',
            'temperature-air',
            'debit-air',
            'tss',

        ];
        const sensorColumn = [
            'dissolver_oxygen',
            'turbidity',
            'salinity',
            'cod',
            'ph',
            'orp',
            'tds',
            'nitrat',
            'temperature_air',
            'debit_air',
            'tss',
            'water_level_cm',
            'water_level_persen',
            'status_pompa',
        ]

        let charts = []
        let intervalId

        Echo.channel('MonitoringTelemetryEvent.683')
            .listen(`MonitoringTelemetryEvent`, function(data) {
                console.log(data);
                console.log('received!');
            });

        const eNode = document.querySelector('select[name="node"]')

        eNode.addEventListener('change', e => {
            if (intervalId) {
                stopInterval()
            }
            const API_URL = `${_base_url}/api/monitoringv2/` + e.target.value;
            fetch(API_URL)
                .then(resp => resp.json())
                .then(resp => {
                    if (resp.latest) {
                        for (const sensor of sensors) {
                            document.querySelector('#status-' + sensor + ' span').innerHTML = parseFloat(resp
                                .latest[sensor.replace('-', '_')]).toFixed(2)
                        }
                        document.querySelector('#status-water-level .cm').textContent = resp.latest[
                            'water_level_cm'] + " cm"
                        document.querySelector('#status-water-level .persen').textContent = resp.latest[
                            'water_level_persen'] + "%"
                        document.querySelector('#status-water-level .progress-bar').style.height = resp.latest[
                            'water_level_persen'] + '%'
                    }

                    if (resp.data.length > 0) {
                        const [phData, phTreshold] = [resp.data.map(d => [d.ph, d.created_at]), resp.data[0]
                            .treshold.find(d => d.variable == 'ph')
                        ];
                        const [codData, codTreshold] = [resp.data.map(d => [d.cod, d.created_at]), resp.data[0]
                            .treshold.find(d => d.variable == 'cod')
                        ];
                        const [nitratData, nitratTreshold] = [resp.data.map(d => [d.nitrat, d.created_at]), resp
                            .data[0].treshold.find(d => d.variable == 'nitrat')
                        ];
                        const [tssData, tssTreshold] = [resp.data.map(d => [d.tss, d.created_at]), resp.data[0]
                            .treshold.find(d => d.variable == 'tss')
                        ];
                        const [debitData, debitTreshold] = [resp.data.map(d => [d.debit_air, d.created_at]),
                            resp.data[0].treshold.find(d => d.variable == 'debit_air')
                        ];
                        const [oxygenData, oxygenTreshold] = [resp.data.map(d => [d.dissolver_oxygen, d
                            .created_at
                        ]), resp.data[0].treshold.find(d => d.variable == 'dissolver_oxygen')];
                        const [turbidityData, turbidityTreshold] = [resp.data.map(d => [d.turbidity, d
                            .created_at
                        ]), resp.data[0].treshold.find(d => d.variable == 'turbidity')];
                        const [salinityData, salinityTreshold] = [resp.data.map(d => [d.salinity, d
                            .created_at
                        ]), resp.data[0].treshold.find(d => d.variable == 'salinity')];
                        const [tdsData, tdsTreshold] = [resp.data.map(d => [d.tds, d.created_at]), resp.data[0]
                            .treshold.find(d => d.variable == 'tds')
                        ];
                        const [orpData, orpTreshold] = [resp.data.map(d => [d.orp, d.created_at]), resp.data[0]
                            .treshold.find(d => d.variable == 'orp')
                        ];
                        const [temperatureData, temperatureTreshold] = [resp.data.map(d => [d.temperature_air, d
                            .created_at
                        ]), resp.data[0].treshold.find(d => d.variable == 'temperature_air')];
                        const [tinggiAirdata, tinggiairTreshold] = [resp.data.map(d => [d.water_level_cm, d
                            .created_at
                        ]), resp.data[0].treshold.find(d => d.variable == 'water_level_cm')];

                        var charts = [
                            new phAir(phData, phTreshold),
                            new CodSensor(codData, codTreshold),
                            new NitratSensor(nitratData, nitratTreshold),
                            new TssSensor(tssData, tssTreshold),
                            new ArusAir(debitData, debitTreshold),
                            new DissolvedOxygen(oxygenData, oxygenTreshold),
                            new TurbiditySensor(turbidityData, turbidityTreshold),
                            new SalinitySensor(salinityData, salinityTreshold),
                            new TdsSensor(tdsData, tdsTreshold),
                            new OrpSensor(orpData, orpTreshold),
                            new TemperatureAir(temperatureData, temperatureTreshold),
                            new TinggiAir(tinggiAirdata, tinggiairTreshold),
                        ];
                        charts.forEach(chart => chart.init());
                    }
                    startInterval(API_URL)
                });
        })

        function startInterval(url) {
            intervalId = setInterval(function() {
                fetch(url)
                    .then(resp => resp.json())
                    .then(resp => {
                        if (resp.latest) {
                            for (const sensor of sensors) {
                                document.querySelector('#status-' + sensor + ' span').innerHTML = parseFloat(
                                    resp.latest[sensor.replace('-', '_')]).toFixed(2);
                            }

                            document.querySelector('#status-water-level .cm').textContent = resp.latest[
                                'water_level_cm'] + " cm";
                            document.querySelector('#status-water-level .persen').textContent = resp.latest[
                                'water_level_persen'] + "%";
                            document.querySelector('#status-water-level .progress-bar').style.height = resp
                                .latest['water_level_persen'] + '%';
                        }

                        if (resp.data.length > 0) {
                            const [phData, phTreshold] = [resp.data.map(d => [d.ph, d.created_at]), resp.data[0]
                                .treshold.find(d => d.variable == 'ph')
                            ];
                            const [codData, codTreshold] = [resp.data.map(d => [d.cod, d.created_at]), resp
                                .data[0].treshold.find(d => d.variable == 'cod')
                            ];
                            const [nitratData, nitratTreshold] = [resp.data.map(d => [d.nitrat, d.created_at]),
                                resp.data[0].treshold.find(d => d.variable == 'nitrat')
                            ];
                            const [tssData, tssTreshold] = [resp.data.map(d => [d.tss, d.created_at]), resp
                                .data[0].treshold.find(d => d.variable == 'tss')
                            ];
                            const [debitData, debitTreshold] = [resp.data.map(d => [d.debit_air, d.created_at]),
                                resp.data[0].treshold.find(d => d.variable == 'debit_air')
                            ];
                            const [oxygenData, oxygenTreshold] = [resp.data.map(d => [d.dissolver_oxygen, d
                                .created_at
                            ]), resp.data[0].treshold.find(d => d.variable == 'dissolver_oxygen')];
                            const [turbidityData, turbidityTreshold] = [resp.data.map(d => [d.turbidity, d
                                .created_at
                            ]), resp.data[0].treshold.find(d => d.variable == 'turbidity')];
                            const [salinityData, salinityTreshold] = [resp.data.map(d => [d.salinity, d
                                .created_at
                            ]), resp.data[0].treshold.find(d => d.variable == 'salinity')];
                            const [tdsData, tdsTreshold] = [resp.data.map(d => [d.tds, d.created_at]), resp
                                .data[0].treshold.find(d => d.variable == 'tds')
                            ];
                            const [orpData, orpTreshold] = [resp.data.map(d => [d.orp, d.created_at]), resp
                                .data[0].treshold.find(d => d.variable == 'orp')
                            ];
                            const [temperatureData, temperatureTreshold] = [resp.data.map(d => [d
                                .temperature_air, d.created_at
                            ]), resp.data[0].treshold.find(d => d.variable == 'temperature_air')];
                            const [tinggiAirdata, tinggiairTreshold] = [resp.data.map(d => [d.water_level_cm, d
                                .created_at
                            ]), resp.data[0].treshold.find(d => d.variable == 'water_level_cm')];


                            var charts = [
                                new phAir(phData, phTreshold),
                                new CodSensor(codData, codTreshold),
                                new NitratSensor(nitratData, nitratTreshold),
                                new TssSensor(tssData, tssTreshold),
                                new ArusAir(debitData, debitTreshold),
                                new DissolvedOxygen(oxygenData, oxygenTreshold),
                                new TurbiditySensor(turbidityData, turbidityTreshold),
                                new SalinitySensor(salinityData, salinityTreshold),
                                new TdsSensor(tdsData, tdsTreshold),
                                new OrpSensor(orpData, orpTreshold),
                                new TemperatureAir(temperatureData, temperatureTreshold),
                                new TinggiAir(tinggiAirdata, tinggiairTreshold),
                            ];
                            charts.forEach(a => {
                                a.chart.update();
                            });
                        }

                    });
            }, 300000);
        }


        function stopInterval() {
            clearInterval(intervalId);
        }
    </script>
@endpush
