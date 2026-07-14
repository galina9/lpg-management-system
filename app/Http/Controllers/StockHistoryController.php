<?php

namespace App\Http\Controllers;

use App\Models\StockHistory;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\StockHistoryExport;

class StockHistoryController extends Controller
{
   public function index(Request $request)
    {
        $query = StockHistory::with([
            'product',
            'user'
        ]);

        if ($request->filled('product')) {

            $query->whereHas('product', function ($q) use ($request) {

                $q->where(
                    'name',
                    'like',
                    '%' . $request->product . '%'
                );

            });

        }

        if ($request->filled('type')) {

            $query->where(
                'type',
                $request->type
            );

        }

        if ($request->filled('from')) {

            $query->whereDate(
                'created_at',
                '>=',
                $request->from
            );

        }

        if ($request->filled('to')) {

            $query->whereDate(
                'created_at',
                '<=',
                $request->to
            );

        }

        $histories = $query
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view(
            'stock-history.index',
            compact('histories')
        );
    }
    public function exportExcel()
    {
        return Excel::download(
            new StockHistoryExport,
            'stock-history.xlsx'
        );
    }
    public function exportPdf()
    {
        $histories = StockHistory::with([
            'product',
            'user'
        ])->latest()->get();

        $pdf = Pdf::loadView(
            'stock-history.pdf',
            compact('histories')
        );

        return $pdf->download(
            'stock-history.pdf'
        );
    }
}