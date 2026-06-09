<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">

    <style>
        body {
            font-family: DejaVu Sans;
            background: #f8fafc;
            color: #1e293b;
        }

        .wrapper {
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 30px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .title {
            font-size: 24px;
            font-weight: bold;
            color: #16a34a;
        }

        .subtitle {
            color: #64748b;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .table td {
            padding: 12px;
            border-bottom: 1px solid #e5e7eb;
        }

        .label {
            width: 35%;
            font-weight: bold;
        }

        .success {
            color: #16a34a;
            font-weight: bold;
        }

        .footer {
            text-align: center;
            margin-top: 40px;
            color: #64748b;
            font-size: 12px;
        }
    </style>

</head>

<body>

    <div class="wrapper">

        <div class="header">

            <div class="title">
                BUKTI PEMBAYARAN
            </div>

            <div class="subtitle">
                Kost Ara Marbun
            </div>

        </div>

        <table class="table">

            <tr>
                <td class="label">Nama Penyewa</td>
                <td>{{ $payment->booking->name }}</td>
            </tr>

            <tr>
                <td class="label">Kamar</td>
                <td>{{ $payment->booking->room->name }}</td>
            </tr>

            <tr>
                <td class="label">Tanggal Mulai Sewa</td>
                <td>
                    {{ \Carbon\Carbon::parse($payment->booking->start_date)->format('d M Y') }}
                </td>
            </tr>

            <tr>
                <td class="label">Jumlah Pembayaran</td>
                <td>
                    Rp {{ number_format($payment->amount) }}
                </td>
            </tr>
            <tr>
                <td class="label">Metode Pembayaran</td>
                <td>

                    @if ($payment->bank)
                        {{ strtoupper($payment->bank) }}
                        Virtual Account
                    @elseif($payment->payment_type)
                        {{ strtoupper($payment->payment_type) }}
                    @else
                        -
                    @endif

                </td>
            </tr>
            <tr>
                <td class="label">Tanggal Pembayaran</td>
                <td>
                    {{ \Carbon\Carbon::parse($payment->paid_at)->format('d M Y H:i') }}
                </td>
            </tr>

            <tr>
                <td class="label">Status</td>
                <td class="success">
                    BERHASIL
                </td>
            </tr>

        </table>

        

    </div>

</body>

</html>
