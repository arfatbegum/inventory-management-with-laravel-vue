<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class SalesReportController extends Controller
{
    function showReportPage()
    {
        $dateFrom = Carbon::now()->startOfMonth()->toDateString();
        $dateTo = Carbon::now()->toDateString();

        return Inertia::render('SalesReportPage', [
            'invoices' => [],
            'summary' => [
                'totalInvoices' => 0,
                'totalSales' => 0,
                'totalDiscount' => 0,
                'totalVat' => 0,
                'totalPayable' => 0,
            ],
            'dateFrom' => $dateFrom,
            'dateTo' => $dateTo,
            'flash' => [],
        ]);
    }

    function downloadPdf(Request $request)
    {
        $user_id = $request->header('id');
        $dateFrom = $request->input('dateFrom');
        $dateTo = $request->input('dateTo');

        $invoices = Invoice::where('user_id', $user_id)
            ->whereBetween('created_at', [$dateFrom, Carbon::parse($dateTo)->endOfDay()])
            ->with('customer', 'invoiceProducts.product')
            ->get();

        $summary = [
            'totalInvoices' => $invoices->count(),
            'totalSales' => $invoices->sum('total'),
            'totalDiscount' => $invoices->sum('discount'),
            'totalVat' => $invoices->sum('vat'),
            'totalPayable' => $invoices->sum('payable'),
        ];

        $pdf = Pdf::loadHtml(view('pdf.sales_report_template', [
            'invoices' => $invoices,
            'summary' => $summary,
            'dateFrom' => $dateFrom,
            'dateTo' => $dateTo
        ])->render());

        return $pdf->download('sales_report_' . $dateFrom . '_to_' . $dateTo . '.pdf');
    }
}
