<?php

namespace App\Exports\Report;

use App\Models\IOTNode;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class NodeRegistrationExport implements FromView, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\view
    */
    public function view(): View
    {
        $data = IOTNode::with(['user', 'edge_computing'])->whereNoTNull('activated_at')->get();
        return view('pages.report.pdf.node_registration', [
            'data' => $data,
            'excel' => '1'
        ]);
    }
}
