<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class ReportController extends Controller
{
    public function index(): View
    {
        // For now, we'll just show a static page or basic stats
        // In a real app, this would fetch public transparency reports
        
        return view('frontend.reports.index', [
            'pageTitle' => 'Reportes de Transparencia',
        ]);
    }
}
