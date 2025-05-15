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
    public function exportPenduduk(Request $request)
    {
        $fileName = 'data-penduduk.xlsx';

        // Add search terms to filename if filtering is applied
        if ($request->has('search') && !empty($request->search)) {
            $fileName = 'data-penduduk-filter-' . date('Y-m-d') . '.xlsx';
        }

        return Excel::download(new PendudukExport($request), $fileName);
    }
}
