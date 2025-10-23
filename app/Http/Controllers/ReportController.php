<?php

namespace App\Http\Controllers;

use DB;
use Carbon\Carbon;
use App\Models\ActivityLog;
use App\Models\Region;
use App\Models\IOTNode;
use App\Models\Maintenance;
use Illuminate\Http\Request;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\MonitoringTelemetry;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\Report\ActivityLogExport;
use App\Exports\Report\RawMonitoringExport;
use App\Exports\Report\MaintenanceLogExport;
use App\Exports\Report\NodeRegistrationExport;

class ReportController extends Controller
{

    public function nodeRegistration(Request $request) {
        $payload = [];
        $payload['data'] = IOTNode::with(['user', 'edge_computing'])->whereNoTNull('activated_at');

        if ($request->has('date') && !empty($request->date)) {
            $payload['data'] = $payload['data']->whereDate('created_at', Carbon::parse($request->date));
        }

        $payload['data'] = $payload['data']->paginate(10);

        return view('pages.report.node_registration', $payload);
    }

    public function nodeRegistrationPDF() {
        $data = IOTNode::with(['user', 'edge_computing'])->whereNoTNull('activated_at')->get();
        $pdf = PDF::loadView('pages.report.pdf.node_registration', [
            'data' => $data
        ]);

        return $pdf->stream('Laporan-registrasi-node.pdf');
    }

    public function nodeRegistrationExcel() {
        return Excel::download(new NodeRegistrationExport, 'IOT_SPARING_DATA_NODE_REGISTRATION.xlsx');
    }

    public function rawMonitoring(Request $request) {
        $payload = [];
        $payload['data']    = MonitoringTelemetry::with(['iot_node.edge_computing']);
        $payload['regions'] = Region::with(['cities' => function ($city) {
                                    $city->select('id', 'region_id', 'name');
                              }])->select('id', 'name')->get();
        $payload['nodes']   = IOTNode::pluck('serial_number', 'id')->toArray();

        if ($request->has('date') && !empty($request->date) && $request->has('to_date') && !empty($request->to_date)) {
            $payload['data'] = $payload['data']->whereBetween(DB::raw('DATE(created_at)'), [Carbon::parse($request->date), Carbon::parse($request->to_date)]);
        }

        if ($request->has('time') && $request->has('to_time') && !empty($request->time) && !empty($request->to_time)) {
            $payload['data'] = $payload['data']->whereBetween(DB::raw('TIME(created_at)'), [$request->time, $request->to_time]);
        }

        if ($request->has('city_id') && !empty($request->city_id)) {
            $payload['data'] = $payload['data']->whereHas('iot_node.edge_computing', function ($query) use ($request) {
                $query->where('city_id', $request->city_id);
            });
        }

        if ($request->has('iot_node_id') && !empty($request->iot_node_id) && $request->iot_node_id != "*") {
            $payload['data'] = $payload['data']->whereHas('iot_node', function ($query) use ($request) {
                $query->where('id', $request->iot_node_id);
            });
        }

        $payload['data'] = $payload['data']->limit(100)->latest()->get();

        return view('pages.report.raw_monitoring', $payload);
    }

    public function rawMonitoringPDF() {
        $data = MonitoringTelemetry::with('iot_node')->limit(100)->latest()->get();
        $pdf = PDF::loadView('pages.report.pdf.raw_monitoring', [
            'data' => $data
        ]);

        return $pdf->stream('Laporan-raw-data-monitoring.pdf');
    }

    public function rawMonitoringExcel() {
        return Excel::download(new RawMonitoringExport, 'IOT_SPARING_DATA_RAW_TELEMETRY.xlsx');
    }

    public function maintenanceLog(Request $request) {
        $payload['data'] = Maintenance::with(['iot_node', 'user']);

        if ($request->has('date') && !empty($request->date)) {
            $payload['data'] = $payload['data']->whereDate('created_at', Carbon::parse($request->date));
        }
        $payload['data'] = $payload['data']->paginate(10);


        return view('pages.report.maintenance_log', $payload);
    }

    public function maintenanceLogPDF() {
        $data =  Maintenance::with(['iot_node', 'user'])->limit(100)->get();
        $pdf = PDF::loadView('pages.report.pdf.maintenance_log', [
            'data' => $data
        ]);
        return $pdf->stream('Laporan-data-riwayat-maintenance.pdf');
    }

    public function maintenanceLogExcel() {
        return Excel::download(new MaintenanceLogExport, 'IOT_SPARING_MAINTENANCE_LOG.xlsx');
    }

    public function activityLog(Request $request) {
        $payload['data'] = ActivityLog::with('user');

        if ($request->has('date') && !empty($request->date)) {
            $payload['data'] = $payload['data']->whereDate('waktu', Carbon::parse($request->date));
        }

        $payload['data'] = $payload['data']->orderBy('created_at', 'desc')->paginate(10);

        return view('pages.report.activity_log', $payload);
    }

    public function activityLogPDF(){
        $data =  ActivityLog::with('user')->limit(100)->get();
        $pdf = PDF::loadView('pages.report.pdf.activity_log', [
            'data' => $data
        ]);
        return $pdf->stream('Laporan-data-log-activity.pdf');
    }

    public function activityLogExcel() {
        return Excel::download(new ActivityLogExport, 'IOT_SPARING_ACTIVITY_LOG.xlsx');
    }

}
