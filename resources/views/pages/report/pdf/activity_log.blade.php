<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Data Log Activity</title>
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
        <h2>Laporan Log Activity</h2>
    </center>
    <br>
    <table class="table" width="100%" cellspacing="0" cellpadding="3" border="1">
        <thead style="background-color: rgb(250 250 250);">
            <tr>
                <th>Nomor</th>
                <th>Waktu</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $row)
            <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{ $row->waktu }}</td>
                <td>Pengguna {{ $row->user->name }} Berhasil {{ $row->status }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
