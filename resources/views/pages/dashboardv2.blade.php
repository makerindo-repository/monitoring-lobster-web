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
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-3">
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
                    <div class="col-md-3">
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
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="row g-2">
                                    <small class="text-secondary">Total Provinsi Terdata</small>
                                    <div class="col-md-6">
                                        <h2 class="fw-bold">
                                            {{ $statistic['region_count'] }}
                                            <small style="font-size:.5em; font-weight:normal;">Prov</small>
                                        </h2>
                                    </div>
                                    <div class="col-md-6 text-end">
                                        <i class="rounded-circle p-3 fs-5 fa-solid fa-map my-auto"
                                            style="color: #00d034; background-color: rgb(0, 208, 52, 0.3);"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="row g-2">
                                    <small class="text-secondary">Total Kota Terdata</small>
                                    <div class="col-md-6">
                                        <h2 class="fw-bold">
                                            {{ $statistic['city_count'] }}
                                            <small style="font-size:.5em; font-weight:normal;">Kota</small>
                                        </h2>
                                    </div>
                                    <div class="col-md-6 text-end">
                                        <i class="rounded-circle p-3 fs-5 fa-solid fa-city my-auto"
                                            style="color: #d00000; background-color: rgb(208, 0, 0, 0.3)"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-12">
                <div class="card p-3 gap-2">
                    <h6 class="fw-bold">Kamera Real-Time</h6>
                    <div class="w-100">
                        <img src="{{ asset('images/dummy-camera.png') }}" alt="Real-Time Capture" class="w-100"
                            style="object-fit: contain;">
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4 g-3">
            <div class="col-4">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="node" class="fw-bolder mb-2">Pilih Node</label>
                            <select class="form-select" name="node" placeholder="Pilih Node" autocomplete="off">
                                <option value="">Pilih Node</option>
                                @foreach ($nodes as $serial_number)
                                    <option value="{{ $serial_number }}">{{ $serial_number }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                @php
                    $sensors = [
                        0 => [
                            'id' => 'dissolver-oxygen',
                            'name' => 'Dissolved Oxygen',
                            'value' => 0,
                            'status' => 'average, Past 20 minutes',
                            'satuan' => 'mg/L',
                        ],
                        1 => [
                            'id' => 'turbidity',
                            'name' => 'Turbidity',
                            'value' => 0,
                            'status' => 'average, Past 20 minutes',
                            'satuan' => 'NTU',
                        ],
                        2 => [
                            'id' => 'salinity',
                            'name' => 'EC/Salinity',
                            'value' => 0,
                            'status' => 'average, Past 20 minutes',
                            'satuan' => 'PSU',
                        ],
                        3 => [
                            'id' => 'cod',
                            'name' => 'COD',
                            'value' => 0,
                            'status' => 'average, Past 20 minutes',
                            'satuan' => 'mg/L',
                        ],
                        4 => [
                            'id' => 'ph',
                            'name' => 'pH',
                            'value' => 0,
                            'status' => 'average, Past 20 minutes',
                            'satuan' => '',
                        ],
                        5 => [
                            'id' => 'orp',
                            'name' => 'ORP',
                            'value' => 0,
                            'status' => 'average, Past 20 minutes',
                            'satuan' => 'mV',
                        ],
                        6 => [
                            'id' => 'tds',
                            'name' => 'TDS',
                            'value' => 0,
                            'status' => 'average, Past 20 minutes',
                            'satuan' => 'ppm',
                        ],
                        7 => [
                            'id' => 'nitrat',
                            'name' => 'Nitrat',
                            'value' => 0,
                            'status' => 'average, Past 20 minutes',
                            'satuan' => 'mg/L',
                        ],
                        8 => [
                            'id' => 'temperature-air',
                            'name' => 'Temperature Air',
                            'value' => 0,
                            'status' => 'average, Past 20 minutes',
                            'satuan' => '°C',
                        ],
                        9 => [
                            'id' => 'debit-air',
                            'name' => 'Debit Air',
                            'value' => 0,
                            'status' => 'average, Past 20 minutes',
                            'satuan' => 'm3/s',
                        ],
                        10 => [
                            'id' => 'tss',
                            'name' => 'TSS',
                            'value' => 0,
                            'status' => 'average, Past 20 minutes',
                            'satuan' => 'mg/L',
                        ],
                        11 => [
                            'id' => 'ni',
                            'name' => 'Nikel',
                            'value' => 0,
                            'status' => 'average, Past 20 minutes',
                            'satuan' => 'mg/L',
                        ],
                        12 => [
                            'id' => 'pb',
                            'name' => 'Timbal',
                            'value' => 0,
                            'status' => 'average, Past 20 minutes',
                            'satuan' => 'mg/L',
                        ],
                        13 => [
                            'id' => 'cd',
                            'name' => 'Kadmium',
                            'value' => 0,
                            'status' => 'average, Past 20 minutes',
                            'satuan' => 'mg/L',
                        ],
                        14 => [
                            'id' => 'as',
                            'name' => 'Arsenik',
                            'value' => 0,
                            'status' => 'average, Past 20 minutes',
                            'satuan' => 'mg/L',
                        ],
                        15 => [
                            'id' => 'cr',
                            'name' => 'Kromium',
                            'value' => 0,
                            'status' => 'average, Past 20 minutes',
                            'satuan' => 'mg/L',
                        ],
                    ];
                @endphp
                <div class="row">
                    @foreach ($sensors as $key => $sensor)
                        <div class="col-12 col-md-3 mb-3">
                            <div class="card h-100" id="status-{{ $sensor['id'] }}">
                                <div class="card-header">
                                    <h6 class="card-title">{{ $sensor['name'] }}</h6>
                                </div>
                                <div class="card-body text-center">
                                    <span>{{ $sensor['value'] }}</span>&nbsp;{{ $sensor['satuan'] }}
                                </div>
                                <div class="card-footer text-muted">
                                    <p style="font-size: 12px;">{{ $sensor['status'] }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <div class="col-12 col-md-3 mb-3">
                        <div class="card h-100" id="status-water-level">
                            <div class="card-header">
                                <h6 class="card-title">Jarak Ke Permukaann Air</h6>
                            </div>
                            <div class="card-body">
                                <div class="row h-100">
                                    <div class="col-6">
                                        <p class="cm" style="font-size: 12px;">0cm</p>
                                        <p class="persen" style="font-size: 12px;">0%</p>
                                    </div>
                                    <div class="col-6">
                                        <div class="progress custom-progress">
                                            <div class="progress-bar bg-info custom-progress-bar" role="progressbar"
                                                aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body pb-0">
                        <h5 class="fw-bold mb-0">Disolved Oxygen</h5>
                        <p class="text-gray fs-7">Disolved Oxygen</p>
                        <div id="DissolvedOxygen"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body pb-0">
                        <h5 class="fw-bold mb-0">Turbidity</h5>
                        <p class="text-gray fs-7">Sensor Turbidity</p>
                        <div id="Turbidity"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body pb-0">
                        <h5 class="fw-bold mb-0">Salinity</h5>
                        <p class="text-gray fs-7">Sensor Salinity</p>
                        <div id="Salinity"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body pb-0">
                        <h5 class="fw-bold mb-0">COD</h5>
                        <p class="text-gray fs-7">Sensor COD</p>
                        <div id="CodSensor"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body pb-0">
                        <h5 class="fw-bold mb-0">pH Air</h5>
                        <p class="text-gray fs-7">Sensor pH Air</p>
                        <div id="phAir"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body pb-0">
                        <h5 class="fw-bold mb-0">Orp</h5>
                        <p class="text-gray fs-7">OrpSensor</p>
                        <div id="OrpSensor"></div>
                    </div>
                </div>
            </div>


        </div>
        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body pb-0">
                        <h5 class="fw-bold mb-0">Tds</h5>
                        <p class="text-gray fs-7">TdsSensor</p>
                        <div id="TdsSensor"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body pb-0">
                        <h5 class="fw-bold mb-0">Nitrat </h5>
                        <p class="text-gray fs-7">Sensor Nitrat</p>
                        <div id="NitratSensor"></div>
                    </div>
                </div>
            </div>

        </div>
        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body pb-0">
                        <h5 class="fw-bold mb-0">Temperature </h5>
                        <p class="text-gray fs-7">Sensor Suhu Air</p>
                        <div id="TemperatureAir"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body pb-0">
                        <h5 class="fw-bold mb-0">Debit Air</h5>
                        <p class="text-gray fs-7">Sensor Debit Air</p>
                        <div id="ArusAir"></div>
                    </div>
                </div>
            </div>

        </div>
        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body pb-0">
                        <h5 class="fw-bold mb-0">TSS</h5>
                        <p class="text-gray fs-7">Sensor TSS</p>
                        <div id="TssSensor"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body pb-0">
                        <h5 class="fw-bold mb-0">Jarak Ke Permukaan Air</h5>
                        <p class="text-gray fs-7">Sensor Jarak Ke Permukaan Air</p>
                        <div id="TinggiAir"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body pb-0">
                        <h5 class="fw-bold mb-0">Nikel</h5>
                        <p class="text-gray fs-7">Sensor Nikel</p>
                        <div id="nikelSensor"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body pb-0">
                        <h5 class="fw-bold mb-0">Timbal</h5>
                        <p class="text-gray fs-7">Sensor Timbal</p>
                        <div id="timbalSensor"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body pb-0">
                        <h5 class="fw-bold mb-0">Kadmium</h5>
                        <p class="text-gray fs-7">Sensor Kadmium</p>
                        <div id="KadmiumSensor"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body pb-0">
                        <h5 class="fw-bold mb-0">Arsenik</h5>
                        <p class="text-gray fs-7">Sensor Arsenik</p>
                        <div id="ArsenikSensor"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body pb-0">
                        <h5 class="fw-bold mb-0">Kromium
                        </h5>
                        <p class="text-gray fs-7">Sensor Kromium
                        </p>
                        <div id="KromiumSensor"></div>
                    </div>
                </div>
            </div>
            {{-- <div class="col-md-6">
                <div class="card">
                    <div class="card-body pb-0">
                        <h5 class="fw-bold mb-0">Arsenik</h5>
                        <p class="text-gray fs-7">Sensor Arsenik</p>
                        <div id="ArsenikSensor"></div>
                    </div>
                </div>
            </div> --}}
        </div>

    </div>
    <br><br><br>
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
