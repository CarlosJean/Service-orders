<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Repositories\reportRepository;
use Illuminate\Http\Request;
use App\Http\Requests\getReportRequest;

class ReportsController extends Controller
{

    protected $reportRepository;
    public function __construct(reportRepository $reportRepository)
    {
        $this->reportRepository = $reportRepository;
    }

    public function index(Request $request){
        return view('reports.reports');

    }

    public function getReport(getReportRequest $request){
        $fromDate = $request->input('fromDate');
        $toDate = $request->input('toDate');
        $type = $request->input('selectedReport');

        return $data = $this->reportRepository->getReportByDate($fromDate, $toDate,  $type);
    }
}
