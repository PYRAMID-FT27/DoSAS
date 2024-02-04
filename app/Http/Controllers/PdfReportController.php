<?php

namespace App\Http\Controllers;

class PdfReportController extends Controller
{
    public function __invoke()
    {
        return view('pdf.index');
    }
}
