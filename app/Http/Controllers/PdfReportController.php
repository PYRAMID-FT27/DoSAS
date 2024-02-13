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
        $html = view('pdf.index', compact('defermentApplication','student','applicationLogs','prevApplication'))->render();
        $pdf = PDF::loadHTML($html);
        $pdf->getDomPDF()->set_option('enable_remote', true);
        return $pdf->download('deferment-application.pdf');
    }
}
