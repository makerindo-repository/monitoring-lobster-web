<?php

namespace App\Exports\Report;

use App\Models\MonitoringTelemetry;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class RawMonitoringExport implements FromView, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\view
    */
    public function view(): View
    {
        $data = MonitoringTelemetry::with('iot_node')->limit(100)->get();
        return view('pages.report.pdf.raw_monitoring', [
            'data' => $data,
            'excel' => '1'
        ]);
    }
}
