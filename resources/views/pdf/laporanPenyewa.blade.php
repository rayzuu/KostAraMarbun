<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">

<style>

body{
    font-family: DejaVu Sans;
    font-size:12px;
    color:#334155;
}

.header{
    text-align:center;
    margin-bottom:25px;
}

.title{
    font-size:24px;
    color:#16a34a;
    font-weight:bold;
}

table{
    width:100%;
    border-collapse:collapse;
}

thead{
    background:#16a34a;
    color:white;
}

th,td{
    padding:10px;
    border:1px solid #e2e8f0;
}

tr:nth-child(even){
    background:#f8fafc;
}

.footer{
    margin-top:25px;
    text-align:center;
    color:#64748b;
}

</style>
</head>
<body>

<div class="header">

    <div class="title">
        LAPORAN DATA PENYEWA
    </div>

    <p>
        Dicetak :
        {{ now()->format('d M Y H:i') }}
    </p>

</div>

<table>

    <thead>

        <tr>

            <th>Nama</th>
            <th>Kamar</th>
            <th>Masuk</th>
            <th>Keluar</th>
            <th>Status Penyewa</th>
            <th>Status Bayar</th>

        </tr>

    </thead>

    <tbody>

        @foreach($reports as $report)

        @php
            $payment = $report->payments->last();
        @endphp

        <tr>

            <td>{{ $report->name }}</td>

            <td>{{ $report->room->name }}</td>

            <td>
                {{ \Carbon\Carbon::parse($report->start_date)->format('d M Y') }}
            </td>

            <td>

                @if($report->end_date)

                    {{ \Carbon\Carbon::parse($report->end_date)->format('d M Y') }}

                @else

                    -

                @endif

            </td>

            <td>
                {{ ucfirst($report->status) }}
            </td>

            <td>
                {{ strtoupper($payment->status ?? '-') }}
            </td>

        </tr>

        @endforeach

    </tbody>

</table>

<div class="footer">

    Sistem Informasi Kost Ara Marbun

</div>

</body>
</html>