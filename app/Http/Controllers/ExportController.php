<?php

namespace App\Http\Controllers;

use App\Services\ExportService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ExportController extends Controller
{
    protected ExportService $exportService;

    public function __construct(ExportService $exportService)
    {
        $this->exportService = $exportService;
    }

    /**
     * Export penduduk data to Excel
     */
    public function exportPenduduk(Request $request): BinaryFileResponse
    {
        return $this->exportService->exportPendudukToExcel($request);
    }
}
