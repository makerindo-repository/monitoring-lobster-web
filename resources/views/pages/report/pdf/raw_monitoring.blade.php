<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Data Monitoring</title>
    <style>
        body{
			font-family: Helvetica, sans-serif;
			margin:0;
            color: #0d1a2b;
            font-size: .6em;
		}
    </style>
</head>
<body>
    <center>
        <h3>Laporan Data Raw Monitoring</h3>
    </center>
    <br>
    <table class="table" width="100%" cellspacing="0" cellpadding="2" border="1">
        <thead style="background-color: rgb(250 250 250);">
            <tr>
                <th rowspan="2">IoT Node</th>
                <th rowspan="2">Waktu</th>
                <th colspan="14" class="text-center">Data Telemetry</th>
            </tr>
            <tr>
                @if(!empty($excel ?? null))
                <th>Suhu Lingkungan</th>
                <th>Humidity Lingkungan</th>
                <th>Disolved Oxygen</th>
                <th>Turbidity</th>
                <th>Salinity</th>
                <th>COD</th>
                <th>pH</th>
                <th>ORP</th>
                <th>TDS</th>
                <th>Nitrat</th>
                <th>Suhu Air</th>
                <th>TSS</th>
                <th>Debit Air</th>
                <th>Jarak Ke Permukaan Air</th>
                <th>Status Solenoid</th>
                @else
                <th width="8.1%">Suhu Lingkungan</th>
                <th width="8.1%">Humidity Lingkungan</th>
                <th width="8.1%">Disolved Oxygen</th>
                <th width="8.1%">Turbidity</th>
                <th width="8.1%">Salinity</th>
                <th width="8.1%">COD</th>
                <th width="8.1%">pH</th>
                <th width="8.1%">ORP</th>
                <th width="8.1%">TDS</th>
                <th width="8.1%">Nitrat</th>
                <th width="8.1%">Suhu Air</th>
                <th width="8.1%">TSS</th>
                <th width="8.1%">Debit Air</th>
                <th width="8.1%">Jarak Ke Permukaan Air</th>
                <th width="8.1%">Status Solenoid</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @forelse ($data as $row)
                <tr>
                    <td>{{ $row->iot_node_serial_number }}</td>
                    <td>{{ $row->created_at }}</td>
                    <td class="fs-7" align="center">{{number_format( $row->temperature_node,0)}} <small>°C</small></td>
                    <td class="fs-7" align="center">{{number_format( $row->humidity_node,0)}} <small>%</small></td>
                    <td class="fs-7" align="center">{{number_format( $row->dissolver_oxygen,2)}} <small>mg/L</small></td>
                    <td class="fs-7" align="center">
                        @if($row->turbidity == 0)
                            NaN
                        @else
                            {{ number_format($row->turbidity, 2) }} <small>NTU</small>
                        @endif
                    </td>
                    <td class="fs-7" align="center">
                        @if($row->salinity == 0)
                            NaN
                        @else
                            {{ number_format($row->salinity, 2) }} <small>PSU</small>
                        @endif
                    </td>
                    <td class="fs-7" align="center">
                        @if($row->cod == 0)
                            NaN
                        @else
                            {{ number_format($row->cod, 2) }} <small>mg/L</small>
                        @endif
                    </td>
                    <td class="fs-7" align="center"><small>pH</small> {{ number_format($row->ph ,2)}}</td>
                    <td class="fs-7" align="center">{{ number_format($row->orp ,2)}} <small>mV</small></td>
                    <td class="fs-7" align="center">
                        @if($row->tds == 0)
                            NaN
                        @else
                            {{ number_format($row->tds, 2) }} <small>ppm</small>
                        @endif
                    </td>
                    <td class="fs-7" align="center">{{ number_format($row->nitrat ,2)}} <small>mg/L</small></td>
                    <td class="fs-7" align="center">{{ number_format($row->temperature_air,0)}} <small>°C</small></td>
                    <td class="fs-7" align="center">
                        @if($row->tss == 0)
                            NaN
                        @else
                            {{ number_format($row->tss, 2) }} <small>mg/L</small>
                        @endif
                    </td>
                    <td class="fs-7" align="center">
                        @if($row->debit_air == 0)
                            NaN
                        @else
                            {{ number_format($row->debit_air, 2) }} <small>m³/s</small>
                        @endif
                    </td>
                    <td class="fs-7" align="center">{{ number_format($row->water_level_cm ,0)}} <small>cm</small></td>
                    <td class="fs-7" align="center">{{ ($row->status_pompa === 1 ? 'Hidup' : 'Mati')}}</td>
                </tr>
            @empty

            @endforelse
        </tbody>
    </table>
</body>
</html>
