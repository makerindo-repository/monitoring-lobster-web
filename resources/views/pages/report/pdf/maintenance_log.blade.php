<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Riwayat Maintenance</title>
    <style>
        body{
			font-family: Helvetica, sans-serif;
			margin:0;
            color: #0d1a2b;
            font-size: .9em;
		}
    </style>
</head>
<body>
    <center>
        <h2>Laporan Riwayat Maintenance</h2>
    </center>
    <br>
    <table class="table" width="100%" cellspacing="0" cellpadding="3" border="1">
        <thead style="background-color: rgb(250 250 250);">
            <tr>
                <th>Nomor Serial</th>
                <th>Keterangan</th>
                <th>Waktu</th>
                <th>Oleh</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $row)
              <tr>
                  <td>{{ $row->iot_node->serial_number }}</td>
                  <td>{{ $row->description }}</td>
                  <td>{{ $row->created_at }}</td>
                  <td>{{ $row->user->name }}</td>
              </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
