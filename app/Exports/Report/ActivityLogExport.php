<?php

namespace App\Exports\Report;

use App\Models\ActivityLog;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ActivityLogExport implements FromView, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\view
    */
    public function view(): View
    {
        $data = ActivityLog::with(['user'])->limit(100)->get();
        return view('pages.report.pdf.activity_log', [
            'data' => $data,
            'excel' => '1'
        ]);
    }
}
