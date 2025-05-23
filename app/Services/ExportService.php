<?php

namespace App\Services;

use App\Exports\PendudukExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ExportService
{
    /**
     * Export penduduk data to Excel
     */
    public function exportPendudukToExcel(Request $request): BinaryFileResponse
    {
        $filename = $this->generateFilename($request);

        return Excel::download(new PendudukExport($request), $filename);
    }

    /**
     * Generate filename based on filters applied
     */
    private function generateFilename(Request $request): string
    {
        $filename = 'data-penduduk';

        // Add filter information to filename if filters are applied
        if ($this->hasFilters($request)) {
            $filename .= '-filtered';
        }

        $filename .= '-' . date('Y-m-d') . '.xlsx';

        return $filename;
    }

    /**
     * Check if any filters are applied
     */
    private function hasFilters(Request $request): bool
    {
        return $request->anyFilled([
            'search',
            'jk',
            'agama_id',
            'pekerjaan_id',
            'pendidikan_id',
            'stat_kawin_id',
            'stat_dasar_id',
            'umur_dari',
            'umur_sampai'
        ]);
    }
}
