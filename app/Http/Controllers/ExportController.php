<?php

namespace App\Http\Controllers;

use App\Exports\PendudukExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    /**
     * Export penduduk data to Excel
     */
    public function exportPenduduk()
    {
        return Excel::download(new PendudukExport, 'data-penduduk.xlsx');
    }
}
