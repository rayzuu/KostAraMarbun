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
    color:#dc2626;
    font-weight:bold;
}

.summary{
    margin-bottom:20px;
    padding:12px;
    background:#fef2f2;
    border:1px solid #fecaca;
}

table{
    width:100%;
    border-collapse:collapse;
}

thead{
    background:#dc2626;
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
        LAPORAN TUNGGAKAN
    </div>

    <p>
        Periode :
        {{ \Carbon\Carbon::create()->month($month)->translatedFormat('F') }}
        {{ $year }}
    </p>

</div>

<div class="summary">

    <strong>Total Tunggakan :</strong>

    Rp {{ number_format(
        $arrears->sum('amount'),
        0,
        ',',
        '.'
    ) }}

</div>

<table>

    <thead>

        <tr>

            <th>Nama</th>
            <th>Kamar</th>
            <th>No HP</th>
            <th>Bulan</th>
            <th>Tahun</th>
            <th>Total</th>

        </tr>

    </thead>

    <tbody>

        @foreach($arrears as $payment)

        <tr>

            <td>

                {{ $payment->booking->name ?? '-' }}

            </td>

            <td>

                {{ $payment->booking->room->name ?? '-' }}

            </td>

            <td>

                {{ $payment->booking->phone ?? '-' }}

            </td>

            <td>

                {{ \Carbon\Carbon::create()->month($payment->payment_month)->translatedFormat('F') }}

            </td>

            <td>

                {{ $payment->payment_year }}

            </td>

            <td>

                Rp {{ number_format($payment->amount,0,',','.') }}

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