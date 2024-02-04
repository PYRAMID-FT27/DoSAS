<?php

namespace App\Http\Controllers;

use App\Models\DefermentApplication;
use App\Services\DefermentApplicationService;
use Barryvdh\DomPDF\Facade\Pdf;

class PdfReportController extends Controller
{
    public function __invoke(DefermentApplication $defermentApplication,DefermentApplicationService $defermentApplicationService)
    {
        $defermentApplicationService->setParameters(
            [
                'da' => $defermentApplication,
                'user' => auth()->user()
            ])->export();
        $student = $defermentApplicationService->output('student');
        $prevApplication = $defermentApplicationService->output('prevApplications');
        $applicationLogs = $defermentApplicationService->output('applicationLogs');
        $pdf = Pdf::loadView('pdf.index', compact('defermentApplication','student','applicationLogs','prevApplication'));
        return $pdf->download('deferment-application.pdf');
    }
}
