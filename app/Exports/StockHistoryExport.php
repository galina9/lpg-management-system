<?php

namespace App\Exports;

use App\Models\StockHistory;
use Maatwebsite\Excel\Concerns\FromCollection;

class StockHistoryExport implements FromCollection
{
    public function collection()
    {
        return StockHistory::with([
            'product',
            'user'
        ])->get();
    }
}