<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Data Monitoring</title>
    <style>
        body {
            font-family: Helvetica, sans-serif;
            margin: 0;
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
                <th rowspan="2">Waktu</th>
                <th colspan="15" class="text-center">Data Telemetry</th>
            </tr>
            <tr>
                @if (!empty($excel ?? null))
                    <th>Pitch</th>
                    <th>Yaw</th>
                    <th>Roll</th>
                    <th>Longitude</th>
                    <th>Latitude</th>
                    <th>Altitude</th>
                    <th>Suhu Lingkungan</th>
                    <th>Kelembapan Lingkungan</th>
                    <th>Pressure</th>
                    <th>Suhu Air</th>
                    <th>Dissolved Oxygen</th>
                    <th>pH</th>
                    <th>Turbidity</th>
                    <th>Salinity</th>
                    <th>Arus</th>
                @else
                    <th width="8.1%">Pitch</th>
                    <th width="8.1%">Yaw</th>
                    <th width="8.1%">Roll</th>
                    <th width="8.1%">Longitude</th>
                    <th width="8.1%">Latitude</th>
                    <th width="8.1%">Altitude</th>
                    <th width="8.1%">Suhu Lingkungan</th>
                    <th width="8.1%">Kelembapan Lingkungan</th>
                    <th width="8.1%">Pressure</th>
                    <th width="8.1%">Suhu Air</th>
                    <th width="8.1%">Dissolved Oxygen</th>
                    <th width="8.1%">pH</th>
                    <th width="8.1%">Turbidity</th>
                    <th width="8.1%">Salinity</th>
                    <th width="8.1%">Arus</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @forelse ($data as $row)
                <tr>
                    <td>{{ $row->created_at }}</td>
                    <td class="fs-7" align="center">{{ (float) $row->pitch }}</td>
                    <td class="fs-7" align="center">{{ (float) $row->yaw }}</td>
                    <td class="fs-7" align="center">{{ (float) $row->roll }}</td>
                    <td class="fs-7" align="center">{{ (float) $row->longitude }}</td>
                    <td class="fs-7" align="center">{{ (float) $row->latitude }}</td>   
                    <td class="fs-7" align="center">{{ (float) $row->altitude }}</td>
                    <td class="fs-7" align="center">{{ $row->suhu }}</td>
                    <td class="fs-7" align="center">{{ $row->kelembapan }}</td>
                    <td class="fs-7" align="center">{{ $row->pressure }}</td>
                    <td class="fs-7" align="center">{{ $row->suhu_air }}</td>
                    <td class="fs-7" align="center">{{ $row->dissolved_oxygen }}</td>
                    <td class="fs-7" align="center">{{ $row->ph }}</td>
                    <td class="fs-7" align="center">{{ $row->turbidity }}</td>
                    <td class="fs-7" align="center">{{ $row->salinity }}</td>
                    <td class="fs-7" align="center">{{ $row->arus }}</td>
                </tr>
            @empty
            @endforelse
        </tbody>
    </table>
</body>

</html>
