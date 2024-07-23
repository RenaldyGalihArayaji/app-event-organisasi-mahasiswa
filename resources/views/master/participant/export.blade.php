<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Peserta</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            /* color: #495057; */
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            /* background-color: #f4f4f9; */
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            /* box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); */
            /* border-radius: 8px; */
            margin-top: 20px;
        }

        .page-heading {
            background-color: #f8f9fa;
            padding: 80px 0;
            text-align: center;
        }

        .page-heading h1 {
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .page-heading p {
            font-size: 1rem;
            margin: 0;
        }

        h3 {
            font-size: 1.75rem;
            margin-top: 1.5rem;
            margin-bottom: 1rem;
            font-weight: bold;
            color: #333;
        }

        p {
            font-size: 1rem;
            margin: 5px 0;
            color: #555;
        }

        .table-container {
            overflow-x: auto;
        }

        .table {
            width: 100%;
            margin-bottom: 1rem;
            background-color: transparent;
            border: 1px solid #dee2e6;
            border-collapse: collapse;
            margin-top: 1.5rem;
            font-size: 14px;
        }

        th, td {
            padding: 12px 15px;
            text-align: left;
        }

        th {
            background-color: #08911f;
            color: white;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #e9e9e9;
        }

        .status {
            padding: 5px 10px;
            border-radius: 5px;
            color: white;
            font-weight: bold;
        }

        .status.hadir {
            background-color: #28a745;
        }

        .status.belum-hadir {
            background-color: #dc3545;
        }
    </style>
</head>
<body>
    <div class="container">
        <h3>Data Peserta {{ ucwords($event->event_name)}}</h3>
        @if (date('d F Y', strtotime($event->start_date )) == date('d F Y', strtotime($event->end_date )))
            <p>Tanggal Event: {{ date('d F Y', strtotime($event->start_date )) }}</p>
            <p>Waktu Event: {{ date('H:i', strtotime($event->start_date )) }} - {{ date('H:i', strtotime($event->end_date )) }} WIB</p>  
        @else
            <p>Tanggal Event: {{ date('d F Y', strtotime($event->start_date )) }} - {{ date('d F Y', strtotime($event->end_date )) }}</p>  
            <p>Waktu Event: {{ date('H:i', strtotime($event->start_date )) }} - {{ date('H:i', strtotime($event->end_date )) }} WIB</p> 
        @endif
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>ID Peserta</th>
                        <th>Nama Lengkap</th>
                        <th>NIM</th>
                        <th>Program Studi</th>
                        <th>Email</th>
                        <th>Nomor Telepon</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->code_registration }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->nim }}</td>
                            <td>{{ $item->prodi }}</td>
                            <td>{{ $item->email }}</td>
                            <td>{{ $item->phone }}</td>
                            <td>
                                <span class="status {{ $item->attendance_status == 'present' ? 'hadir' : 'belum-hadir' }}">
                                    {{ $item->attendance_status == 'present' ? 'Hadir' : 'Belum Hadir' }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
