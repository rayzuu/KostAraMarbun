<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Payment;
use App\Models\Booking;

class ReportController extends Controller
{
    public function index(Request $request)
    {

        $month = $request->month ?? now()->month;

        $year = $request->year ?? now()->year;

        $reports = Payment::with(
            'booking.room'
        )
        ->where('payment_month', $month)
        ->where('payment_year', $year)
        ->latest()
        ->get();

        $totalIncome = $reports
            ->where('status', 'paid')
            ->sum('amount');

        return view(
            'admin.laporan.report', 
            compact(
                'reports',
                'totalIncome',
                'month',
                'year'
            )
        );
    }

    public function exportPaymentPdf(Request $request)
{
    $month = $request->month ?? now()->month;
    $year = $request->year ?? now()->year;

    $reports = Payment::with([
        'booking.room'
    ])
    ->where('payment_month', $month)
    ->where('payment_year', $year)
    ->latest()
    ->get();

    $totalIncome = $reports
        ->where('status', 'paid')
        ->sum('amount');

    $pdf = Pdf::loadView(
        'pdf.laporanPembayaran',
        compact(
            'reports',
            'month',
            'year',
            'totalIncome'
        )
    );

    return $pdf->download(
        'Laporan-Pembayaran.pdf'
    );
}

    public function reportPenyewa(Request $request)
{

    $month = $request->month ?? now()->month;

    $year = $request->year ?? now()->year;

    $tenantStatus = $request->tenant_status;

    $paymentStatus = $request->payment_status;

    $query = Booking::with([
        'room',
        'payments'
    ]);

    // FILTER BULAN & TAHUN
    $query->whereMonth(
        'start_date',
        $month
    );

    $query->whereYear(
        'start_date',
        $year
    );

    // FILTER STATUS PENYEWA
    if($tenantStatus){

        $query->where(
            'status',
            $tenantStatus
        );

    }

    $reports = $query
        ->latest()
        ->get();

    // FILTER PAYMENT
    if($paymentStatus){

        $reports = $reports->filter(function($booking) use ($paymentStatus){

            $payment = $booking->payments->last();

            return $payment &&
                $payment->status == $paymentStatus;

        });

    }

    return view(
        'admin.laporan.reportPenyewa',
        compact(
            'reports',
            'month',
            'year',
            'tenantStatus',
            'paymentStatus'
        )
    );
}

public function exportTenantPdf(Request $request)
{
    $month = $request->month ?? now()->month;
    $year = $request->year ?? now()->year;

    $tenantStatus = $request->tenant_status;
    $paymentStatus = $request->payment_status;

    $query = Booking::with([
        'room',
        'payments'
    ]);

    $query->whereMonth(
        'start_date',
        $month
    );

    $query->whereYear(
        'start_date',
        $year
    );

    if($tenantStatus){

        $query->where(
            'status',
            $tenantStatus
        );

    }

    $reports = $query
        ->latest()
        ->get();

    if($paymentStatus){

        $reports = $reports->filter(function($booking) use ($paymentStatus){

            $payment = $booking->payments->last();

            return $payment &&
                $payment->status == $paymentStatus;

        });

    }

    $pdf = Pdf::loadView(
        'pdf.laporanPenyewa',
        compact(
            'reports',
            'month',
            'year'
        )
    );

    return $pdf->download(
        'Laporan-Penyewa.pdf'
    );
}

public function exportArrearsPdf(Request $request)
{
    $month = $request->month ?? now()->month;
    $year = $request->year ?? now()->year;

    $arrears = Payment::with([
        'booking.room'
    ])
    ->where('status', 'unpaid')
    ->where('payment_month', $month)
    ->where('payment_year', $year)
    ->latest()
    ->get();

    $pdf = Pdf::loadView(
        'pdf.laporanTunggakan',
        compact(
            'arrears',
            'month',
            'year'
        )
    );

    return $pdf->download(
        'Laporan-Tunggakan.pdf'
    );
}


}