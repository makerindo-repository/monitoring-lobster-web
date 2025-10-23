<?php

namespace App\Exports\Report;

use App\Models\Maintenance;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class MaintenanceLogExport implements FromView, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\view
    */
    public function view(): View
    {
        $data = Maintenance::with(['iot_node', 'user'])->limit(100)->get();
        return view('pages.report.pdf.maintenance_log', [
            'data' => $data,
            'excel' => '1'
        ]);
    }
}
