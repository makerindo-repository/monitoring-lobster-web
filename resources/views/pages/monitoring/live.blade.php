@extends('pages.layouts.monitoring_app')

{{-- STYLES --}}
@push('header')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
        integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
        crossorigin="" />
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" type="text/css">

@endpush

@push('style')
    <style>
        #map {
            height: 250px;
        }
    </style>
@endpush

@section('title')
    <span class="fw-bold">MONITORING</span> <span id="iot">{{ $node->serial_number }};
        Node-{{ $node->edge_computing_node }}</span>
@endsection

@section('content')
    <div class="modal fade" id="modalDetail" tabindex="-1" aria-labelledby="modalDetailLabel" aria-hidden="true"
        style="font-size:.85em !important;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body tet-center">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-gray mb-2">Foto Pemasangan</h6>
                            <img src="{{ asset($node->picture_genba) }}" width="100%">
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-gray mb-2">Tanda Tangan</h6>
                            <img src="{{ asset($node->signature) }}" width="100%">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid mt-3">
        <div class="row">
            <div class="col-md-6">
                <div id="map" class="map"></div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="fw-bold mb-0">Informasi</h5>
                        <p class="text-gray fs-7">Detail Informasi IoT Node</p>
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table" style="font-size:.8em">
                                    <tr>
                                        <td width="18%">Nomor Serial</td>
                                        <td width="1%">:</td>
                                        <td>{{ $node->serial_number }}</td>
                                    </tr>
                                    <tr>
                                        <td>Edge Node</td>
                                        <td width="1%">:</td>
                                        <td>Node-{{ $node->edge_computing_node }}</td>
                                    </tr>
                                    <tr>
                                        <td>Lokasi</td>
                                        <td>:</td>
                                        <td>
                                            {{ $node->edge_computing->city ? $node->edge_computing->city->name : 'undefined' }},
                                            {{ $node->edge_computing->city && $node->edge_computing->city->region ? $node->edge_computing->city->region->name : 'undefined' }}
                                        </td>
                                    </tr>
                                </table>
                                <span class="fw-bolder d-inline-block fs-7 ms-1" data-bs-toggle="modal"
                                    data-bs-target="#modalDetail" style="color:#1e88e5; cursor: pointer;">Lihat lebih
                                    lengkap</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- <div class="row mt-3">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body pb-0">
                        <h5 class="fw-bold mb-0">pH Air</h5>
                        <p class="text-gray fs-7">Sensor pH Air</p>
                        <div id="phAir"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body pb-0">
                        <h5 class="fw-bold mb-0">COD</h5>
                        <p class="text-gray fs-7">Sensor COD</p>
                        <div id="CodSensor"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body pb-0">
                        <h5 class="fw-bold mb-0">Kelembapan & Suhu</h5>
                        <p class="text-gray fs-7">Kondisi suhu & Kelembapan pada alat</p>
                        <div class="row text-center mt-4">
                            <div class="col">
                                <h2 class="mb-1"><span id="iot-humidity">0</span>%</h2>
                                <p class="text-gray">Kelembapan IoT</p>
                            </div>
                            <div class="col">
                                <h2 class="mb-1"><span id="iot-temperature">0</span><sup>°C</sup></h2>
                                <p class="text-gray">Suhu IoT</p>
                            </div>
                        </div>
                        <div class="row text-center mt-3">
                            <div class="col">
                                <h2 class="mb-1"><span id="edge-humidity">0</span>%</h2>
                                <p class="text-gray">Kelembapan Edge</p>
                            </div>
                            <div class="col">
                                <h2 class="mb-1"><span id="edge-temperature">0</span><sup>°C</sup></h2>
                                <p class="text-gray">Suhu Edge</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body pb-0">
                        <h5 class="fw-bold mb-0">Amonium </h5>
                        <p class="text-gray fs-7">Sensor Amonium</p>
                        <div id="AmoniumSensor"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body pb-0">
                        <h5 class="fw-bold mb-0">TSS</h5>
                        <p class="text-gray fs-7">Sensor TSS</p>
                        <div id="TssSensor"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body pb-0">
                        <h5 class="fw-bold mb-0">Debit Air</h5>
                        <p class="text-gray fs-7">Sensor Debit Air</p>
                        <div id="ArusAir"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body pb-0">
                        <h5 class="fw-bold mb-0">Disolved Oxygen</h5>
                        <p class="text-gray fs-7">Disolved Oxygen</p>
                        <div id="DissolvedOxygen"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body pb-0">
                        <h5 class="fw-bold mb-0">Turbidity</h5>
                        <p class="text-gray fs-7">Sensor Turbidity</p>
                        <div id="Turbidity"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body pb-0">
                        <h5 class="fw-bold mb-0">Salinity</h5>
                        <p class="text-gray fs-7">Sensor Salinity</p>
                        <div id="Salinity"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body pb-0">
                        <h5 class="fw-bold mb-0">Tds</h5>
                        <p class="text-gray fs-7">TdsSensor</p>
                        <div id="TdsSensor"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body pb-0">
                        <h5 class="fw-bold mb-0">Orp</h5>
                        <p class="text-gray fs-7">OrpSensor</p>
                        <div id="OrpSensor"></div>
                    </div>
                </div>
            </div>
        </div> --}}

        <div id="iot-humidity" hidden></div>
        <div id="iot-temperature" hidden></div>
        <div id="edge-humidity" hidden></div>
        <div id="edge-temperature" hidden></div>

        {{-- Data Table --}}
        <div class="row mt-5 justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table fs-7" id="raw">
                                <thead>
                                    <tr>
                                        <th align="center" class="text-center">Waktu</th>
                                        <th align="center" class="text-center">Suhu Lingkungan</th>
                                        <th align="center" class="text-center">Humidity Lingkungan</th>
                                        <th align="center" class="text-center">Dissolved Oxygen</th>
                                        <th align="center" class="text-center">Turbidity</th>
                                        <th align="center" class="text-center">EC/Salinity</th>
                                        <th align="center" class="text-center">COD</th>
                                        <th align="center" class="text-center">pH</th>
                                        <th align="center" class="text-center">ORP</th>
                                        <th align="center" class="text-center">TDS</th>
                                        <th align="center" class="text-center">Nitrat</th>
                                        <th align="center" class="text-center">Suhu Air</th>
                                        <th align="center" class="text-center">TSS</th>
                                        <th align="center" class="text-center">Debit air</th>
                                        <th align="center" class="text-center">Jarak Ke Permukaan Air</th>
                                        <th align="center" class="text-center">Status Solenoid</th>
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
        {{-- END Data Table --}}

    </div>
@endsection
{{-- END CONTENT --}}

{{-- SCRIPTS IN APP --}}
@push('footer')
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
        integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
        crossorigin=""></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" type="text/javascript"></script>
    <script src="{{ asset('js/MonitoringConfig.js') }}"></script>
    <script src="{{ asset('js/phAir.js') }}"></script>
    <script src="{{ asset('js/CodSensor.js') }}"></script>
    <script src="{{ asset('js/NitratSensor.js') }}"></script>
    <script src="{{ asset('js/TssSensor.js') }}"></script>
    <script src="{{ asset('js/DissolvedOxygen.js') }}"></script>
    <script src="{{ asset('js/Temperature.js') }}"></script>
    <script src="{{ asset('js/ArusBaterai.js') }}"></script>
    <script src="{{ asset('js/Voltage.js') }}"></script>
    <script src="{{ asset('js/ArusAir.js') }}"></script>
    <script src="{{ asset('js/Turbidity.js') }}"></script>
    <script src="{{ asset('js/Salinity.js') }}"></script>
    <script src="{{ asset('js/OrpSensor.js') }}"></script>
    <script src="{{ asset('js/TdsSensor.js') }}"></script>
    <script src="{{ asset('js/Monitoring.js') }}"></script>
@endpush
@push('script')
    <script>
        const API_URL = `${_base_url}/api/monitoring/?n={{ $node->serial_number }}`;
        TRUSUR_MONITORING = new Monitor("{{ $node->lat }}", "{{ $node->lng }}");
        console.log(API_URL)

        function loadDataAndRefresh() {
            function fetchData() {
                fetch(API_URL)
                    .then(resp => resp.json())
                    .then(resp => {
                        let {
                            status,
                            data,
                            treshold,
                        } = resp;

                        if (status === 'success' && data) {
                            let dataTable = data.sort((a, b) => b.id - a.id);
                            TRUSUR_MONITORING.init(data, treshold, dataTable);
                            Echo.channel('MonitoringTelemetryEvent.{{ $node->serial_number }}')
                            .listen(`MonitoringTelemetryEvent`, function(data) {
                            TRUSUR_MONITORING.update(data);
                                    console.log(data);
                                    console.log('received!');
                                });
                        }
                    })
                    .catch(error => {
                        console.error("Error fetching data:", error);
                    });
            }
            const interval = 2000;
            setInterval(fetchData, interval);
            fetchData();
        }
        loadDataAndRefresh();
    </script>
    {{-- <script>
        const API_URL = `${_base_url}/api/monitoring/?n={{ $node->id }}`;
        TRUSUR_MONITORING = new Monitor("{{ $node->lat }}", "{{ $node->lng }}");

        async function fetchData() {
            try {
                const resp = await fetch(API_URL);
                if (resp.ok) {
                    const data = await resp.json();
                    let {
                        status,
                        data: newData,
                        treshold,
                    } = data;

                    if (status === 'success' && newData) {
                        let dataTable = newData.sort((a, b) => b.id - a.id);
                        TRUSUR_MONITORING.init(newData, treshold, dataTable);
                    }
                } else {
                    console.error("Error fetching data:", resp.status);
                }
            } catch (error) {
                console.error("Error fetching data:", error);
            }
        }

        function loadDataAndRefresh() {
            fetchData(); // Memanggil fetchData pertama kali
            const interval = 10000;
            setInterval(fetchData, interval); // Memanggil fetchData setiap 10 detik
        }

        loadDataAndRefresh();
    </script> --}}
@endpush
