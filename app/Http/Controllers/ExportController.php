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
        $filename = 'data-penduduk';

        // Add filter information to filename if filters are applied
        if ($request->anyFilled(['search', 'jk', 'agama_id', 'pekerjaan_id', 'pendidikan_id', 'stat_kawin_id', 'stat_dasar_id'])) {
            $filename .= '-filtered';
        }

        $filename .= '-' . date('Y-m-d') . '.xlsx';

        return Excel::download(new PendudukExport($request), $filename);
    }
}
