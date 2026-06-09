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

.summary{
    margin-bottom:20px;
    padding:12px;
    background:#f0fdf4;
    border:1px solid #bbf7d0;
}

.stats{
    width:100%;
    margin-bottom:20px;
}

.stat-box{
    width:23%;
    display:inline-block;
    padding:10px;
    margin-right:1%;
    border:1px solid #e5e7eb;
    background:#f8fafc;
    text-align:center;
    border-radius:6px;
}

.stat-title{
    font-size:11px;
    color:#64748b;
}

.stat-value{
    font-size:16px;
    font-weight:bold;
    margin-top:5px;
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
        LAPORAN PEMBAYARAN
    </div>

    <p>
        Periode :
        {{ \Carbon\Carbon::create()->month($month)->translatedFormat('F') }}
        {{ $year }}
    </p>

</div>

<div class="summary">

    <strong>Total Pendapatan :</strong>

    Rp {{ number_format($totalIncome,0,',','.') }}

</div>

@php

$totalPayment = $reports->count();

$totalPaid = $reports
    ->where('status','paid')
    ->count();

$totalUnpaid = $reports
    ->where('status','unpaid')
    ->count();

@endphp

<div class="stats">

    <div class="stat-box">

        <div class="stat-title">
            Total Transaksi
        </div>

        <div class="stat-value">
            {{ $totalPayment }}
        </div>

    </div>

    <div class="stat-box">

        <div class="stat-title">
            Pembayaran Berhasil
        </div>

        <div class="stat-value">
            {{ $totalPaid }}
        </div>

    </div>

    <div class="stat-box">

        <div class="stat-title">
            Belum Dibayar
        </div>

        <div class="stat-value">
            {{ $totalUnpaid }}
        </div>

    </div>

    <div class="stat-box">

        <div class="stat-title">
            Total Pendapatan
        </div>

        <div class="stat-value">
            Rp {{ number_format($totalIncome,0,',','.') }}
        </div>

    </div>

</div>

<table>

    <thead>

        <tr>

            <th>Penyewa</th>
            <th>Kamar</th>
            <th>Metode</th>
            <th>Total</th>
            <th>Status</th>
            <th>Tanggal Bayar</th>

        </tr>

    </thead>

    <tbody>

        @foreach($reports as $report)

        <tr>

            <td>
                {{ $report->booking->name ?? '-' }}
            </td>

            <td>
                {{ $report->booking->room->name ?? '-' }}
            </td>

            <td>

                @if($report->bank)

                    {{ strtoupper($report->bank) }}

                @elseif($report->payment_type)

                    {{ strtoupper($report->payment_type) }}

                @else

                    -

                @endif

            </td>

            <td>

                Rp {{ number_format($report->amount,0,',','.') }}

            </td>

            <td>

                {{ strtoupper($report->status) }}

            </td>

            <td>

                @if($report->paid_at)

                    {{ \Carbon\Carbon::parse($report->paid_at)->format('d M Y H:i') }}

                @else

                    -

                @endif

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