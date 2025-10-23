<?php

namespace App\Http\Controllers\Api;

use Auth;

use App\User;
use Validator;
use App\Models\City;
use App\Models\Sensor;
use App\Models\IOTNode;
use App\Models\Treshold;
use App\Models\RawSensor;

use App\Models\Maintenance;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\EdgeComputing;
use Illuminate\Http\JsonResponse;
use App\Models\MonitoringTelemetry;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Services\GeoJsonService;
use App\Events\MonitoringTelemetryEvent;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Resources\EdgeComputingResource;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Http\Response;


class GeneralController extends Controller
{

    public function getCity()
    {
        return response()->json([
            'status' => 'success',
            'data'   => City::with(['region' => function ($c) {
                $c->select('id', 'code', 'name');
            }])->select('id', 'code', 'region_id', 'name')->get()
        ]);
    }

    public function getMarkerEdge(Request $request)
    {
        $edges = EdgeComputing::with(['iot_nodes'])->get();

        return (new GeoJsonService)->getPointOf($edges, EdgeComputingResource::class);
    }

    public function getDetailMarkerEdge(Request $request)
    {
        return response()->json([
            'status' => 'success',
            'data'   => EdgeComputing::with('iot_nodes')->whereId($request->id)->firstOrFail()
        ]);
    }

    public function checkStatusNode(Request $request)
    {
        $category = strtolower($request->category);
        $maintenance = $request->maintenance;

        if (empty($category)) {
            return response()->json([
                'status' => 'fail',
                'messages' => ["category can't be null"]
            ]);
        }

        if ($category === 'node') {
            $data = IOTNode::where('serial_number', $request->serial_number)->first();
        } else if ($category === 'edge') {
            $data = EdgeComputing::where('serial_number', $request->serial_number)->first();
        }

        if ($maintenance == 1) {
            if (!$data) {
                return response()->json([
                    'status' => 'fail',
                    'messages' => ['Invalid number.'],
                    'payload' => $request->all()
                ]);
            }
        } else {
            if (!$data || $data->activated_at) {
                return response()->json([
                    'status' => 'fail',
                    'messages' => ['Invalid number.'],
                    'payload' => $request->all()
                ]);
            }
        }

        return response()->json([
            'status'   => 'success',
            'messages' => ['Serial number is valid.'],
            'id'       => $data->id,
            'category' => $category
        ]);
    }

    public function checkStatusNodeMaintenance(Request $request)
    {
        $category = $request->category;

        if (empty($category)) {
            return response()->json([
                'status' => 'fail',
                'messages' => ["category can't be null"]
            ]);
        }

        if ($category === 'node') {
            $data = IOTNode::where('serial_number', $request->serial_number)->first();
        } else if ($category === 'edge') {
            $data = EdgeComputing::where('serial_number', $request->serial_number)->first();
        }

        if (!$data) {
            return response()->json([
                'status' => 'fail',
                'messages' => ['Invalid number.']
            ]);
        }

        return response()->json([
            'status'   => 'success',
            'messages' => ['Serial number is valid.'],
            'id'       => $data->id,
            'category' => $category
        ]);
    }

    public function maintenanceDevice(Request $request)
    {

        $picture = null;
        $signature = null;

        if ($request->hasFile('picture')) {
            $picture = $this->image_intervention($request->file('picture'), 'images/iot_node/maintenance/picture/');
        }
        if ($request->hasFile('signature')) {
            $signature = $this->image_intervention($request->file('signature'), 'images/iot_node/maintenance/signature/');
        }

        Maintenance::create([
            'iot_node_id' => $request->iot_node_id,
            'user_id' => $request->user_id,
            'description' => $request->description,
            'picture' => $picture,
            'signature' => $signature,
            'lat' => $request->lat ?? null,
            'lng' => $request->lng ?? null
        ]);

        return response()->json(['status' => 'success', 'messages' => 'success']);
    }
public function registrationNode(Request $request)
{
    $category = strtolower($request->category);

    if (empty($category)) {
        return response()->json(['status' => 'fail', 'messages' => 'Category cannot be empty'], 400);
    }

    $dateNow = now();
    $picture_genba = null;
    $signature = null;
    $path_image = '';

    try {
        if ($category == 'edge') {
            $path_image = 'edge_computing/';
            $data = EdgeComputing::findOrFail($request->id);
        } elseif ($category == 'node') {
            $path_image = 'iot_node/';
            $data = IOTNode::findOrFail($request->id);
        } else {
            return response()->json(['status' => 'fail', 'messages' => 'Invalid category'], 400);
        }
    } catch (ModelNotFoundException $exception) {
        return response()->json(['status' => 'fail', 'messages' => 'Data not found'], 404);
    }

    try {
        if ($request->hasFile('picture')) {
            $picture_genba = $this->image_intervention($request->file('picture'), 'images/' . $path_image . 'genba/');
        }
        if ($request->hasFile('signature')) {
            $signature = $this->image_intervention($request->file('signature'), 'images/' . $path_image . 'signature/');
        }

        $payload = [
            'activated_by' => $request->user_id,
            'activated_at' => $dateNow,
            'picture_genba' => $picture_genba,
            'signature' => $signature,
            'lat' => $request->lat ?? null,
            'lng' => $request->lng ?? null
        ];

        $data->update($payload);

        return response()->json(['status' => 'success', 'messages' => 'Data updated successfully']);
    } catch (\Exception $exception) {
        return response()->json(['status' => 'error', 'messages' => $exception->getMessage()], 500);
    }
}

    public function listActivatedNode(Request $request): JsonResponse
    {
        $user = User::select('id', 'name', 'email', 'created_at')->findOrFail($request->user_id);

        $iotnodes = IOTNode::query()
            ->select(['id', 'serial_number', 'ip', 'ip_gateway', 'picture', 'installed_at', 'activated_at', 'picture_genba'])
            ->with([
                'city:id,code,name'
            ])
            ->where('user_id', $user->id)
            ->whereNotNull('activated_at')
            ->get();

        return response()->json($iotnodes);
    }

    public function detailActivatedNode(Request $request, $serial_number): JsonResponse
    {
        $user = User::findOrFail($request->user_id);

        $iotnode = IOTNode::query()
            ->with([
                'city:id,code,name,region_id',
                'city.region:id,code,name',
                'edge_computing',
            ])
            ->where('user_id', $user->id)
            ->where('serial_number', $serial_number)
            ->firstOrFail();

        $sensorData = [];

        foreach ($iotnode->treshold as $treshold) {
            $telemetryData = MonitoringTelemetry::select($treshold->variable)
                ->where('iot_node_serial_number', $serial_number)
                ->orderByDesc('created_at')
                ->first();

            if ($telemetryData) {
                $sensorData[$treshold->variable] = [
                    'value' => $telemetryData->{$treshold->variable},
                    'min_value' => $treshold->value_min,
                    'max_value' => $treshold->value_max,
                ];
            }
        }

        $iotnode->sensor = $sensorData;
        if ($sensorData) {
            unset($iotnode->treshold);
        }


        return response()->json($iotnode);
    }
    public function listTelemetriNode(Request $request, $id): JsonResponse
    {
        $user = User::select('id', 'name', 'email', 'created_at')->findOrFail($request->user_id);
        $columns = $request->query('column', '*');
        $limit = $request->query('limit', 10);

        $telemetries = $this->telemetriNode($id, $user->id, $columns)
            ->orderByDesc('created_at')
            ->limit($limit)
            ->get();

        return response()->json($telemetries);
    }

    public function rangeTelemetriNode(Request $request, $id): JsonResponse
    {
        $user = User::select('id', 'name', 'email', 'created_at')->findOrFail($request->user_id);
        $columns = $request->query('column', '*');
        $startDate = $request->query('startDate', now('Asia/Jakarta')->format('Y-m-d'));
        $endDate = $request->query('endDate', now('Asia/Jakarta')->format('Y-m-d'));

        $telemetries = [];

        $this->telemetriNode($id, $user->id, $columns)
            ->whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate)
            ->orderByDesc('created_at')
            ->chunk(100, function ($data) use (&$telemetries) {
                $telemetries[] = $data;
            });

        return response()->json([
            'startDate' => $startDate,
            'endDate' => $endDate,
            'telemetries' => collect($telemetries)->flatten()
        ]);
    }

    public function monthTelemetriNode(Request $request, $id): JsonResponse
    {
        $user = User::select('id', 'name', 'email', 'created_at')->findOrFail($request->user_id);
        $columns = $request->query('column', '*');
        $now = now('Asia/Jakarta');
        $year = $request->query('year', (string) $now->year);
        $month = $request->query('month', (string) $now->month);
        $telemetries = [];

        $this->telemetriNode($id, $user->id, $columns)
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->orderByDesc('created_at')
            ->chunk(100, function ($data) use (&$telemetries) {
                $telemetries[] = $data;
            });

        return response()->json([
            'year' => $year,
            'month' => $month,
            'telemetries' => collect($telemetries)->flatten()
        ]);
    }

    public function dayTelemetriNode(Request $request, $id): JsonResponse
    {
        $user = User::select('id', 'name', 'email', 'created_at')->findOrFail($request->user_id);
        $columns = $request->query('column', '*');
        $date = $request->query('date', now('Asia/Jakarta')->format('Y-m-d'));

        $telemetries = [];

        $this->telemetriNode($id, $user->id, $columns)
            ->whereDate('created_at', $date)
            ->orderByDesc('created_at')
            ->chunk(100, function ($data) use (&$telemetries) {
                $telemetries[] = $data;
            });

        return response()->json([
            'date' => $date,
            'telemetries' => collect($telemetries)->flatten()
        ]);
    }

    public function telemetriNode(String $serialNumber, Int $user_id, $columns = '*'): Builder
    {
        return RawSensor::query()
            ->select([$columns])
            ->where('iot_node_serial_number', $serialNumber)
            ->whereHas('iot_node', function ($node) use ($user_id) {
                $node->where('activated_by', $user_id);
            });
    }

    public function getProfile(Request $request)
    {
        $data = User::select('id', 'name', 'email', 'created_at')->findOrFail($request->user_id);
        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
    }

    public function updateProfile(Request $request)
    {
        $data = User::findOrFail($request->user_id);

        if (User::whereEmail($request->email)->where('id', '!=', $request->user_id)->exists()) {
            return response()->json([
                'status' => 'fail',
                'messages' => 'email sudah digunakan.'
            ]);
        }

        $data->update($request->only('name', 'email'));

        return response()->json([
            'status' => 'success',
            'messages' => 'sukses update.'
        ]);
    }

    public function getMonitoringData(Request $request)
    {
        return response()->json([
            'status' => 'success',
            'data' => MonitoringTelemetry::where('iot_node_serial_number', $request->n)->latest('created_at')->limit(10)->get(),
            'treshold' => Treshold::select('iot_node_serial_number','variable', 'value_min','value_max')->get()

        ]);
    }

    public function dummyData(Request $request)
    {
        // event(new MonitoringTelemetryEvent($request->suhu));
        // return response()->json('data received');
    }

    public function storeTelemetry(Request $request)
    {
        $node = IOTNode::where('serial_number', $request->iot_node_id)->firstOrFail();

        if (!$node->activated_at) {
            return response()->json([
                'status' => 'failed',
                'messages' => [
                    'device not available.'
                ]
            ]);
        }

        $monitoringTelemetry = MonitoringTelemetry::create(array_merge(
            [
                "iot_node_id" => $node->id
            ],
            $request->only("temperature_node", "temperature_edge", "humidity_node", "humidity_edge", "ph", "cod", "ammonia", "tss", "debit")
        ));

        event(new MonitoringTelemetryEvent($request->iot_node_id, $request->all(), $monitoringTelemetry->created_at));

        return response()->json([
            'status' => 'success'
        ]);
    }

    // Login app
    public function authLogin(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'status' => 'fail',
                'messages' => $validate->errors()->all()
            ]);
        }

        if (Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'status'   => 'success',
                'messages' => ['Successfully authenticated!'],
                'data' => [
                    'user' => User::where('email', $request->email)->first()
                ]
            ]);
        }

        return response()->json([
            'status' => 'fail',
            'messages' => ['Email atau password yang dimasukan tidak valid.'],
        ]);
        return response()->json($request->all());
    }

    // aktivasi device
    public function activateDevice(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'category'      => 'required|in:edge_computing,iot_node',
            'serial_number' => ['required', 'in:' . $this->getDeviceSerialNumbers($request->category, 'activate')],
            'user_id'       => ['required', 'in:' . $this->getUserIds()]
        ]);

        if ($validate->fails()) {
            return response()->json([
                'status'   => 'fail',
                'api_uri'  => url('api/activate-device'),
                'messages' =>  $validate->errors()->all(),
            ]);
        }

        $serial_number = $request->serial_number;
        $dateNow       = now();
        $dateExpiredAt = $dateNow->addYears(1);

        $payload = [
            'activated_by' => $request->user_id,
            'activated_at' => $dateNow,
            'expired_at'   => $dateExpiredAt
        ];

        if ($request->category === 'edge_computing') {
            // EdgeComputing::where('serial_number', $serial_number)->update($payload);
        } else if ($request->category === 'iot_node') {
            IOTNode::where('serial_number', $serial_number)->update($payload);
        }

        return response()->json(['status' => 'success']);
    }

    // Store installasi device
    public function installationDevice(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'category'      => 'required|in:edge_computing,iot_node',
            'serial_number' => ['required', 'in:' . $this->getDeviceSerialNumbers($request->category)],
            'picture'       => 'nullable|image|mimes:jpeg,jpg,png'
        ]);

        if ($validate->fails()) {
            return response()->json([
                'status'   => 'fail',
                'api_uri'  => url('api/installation-device'),
                'messages' =>  $validate->errors()->all(),
            ]);
        }

        $category = $request->category;
        $serial_number = $request->serial_number;
        $dateNow       = now();
        $picture_genba = null;

        if ($request->hasFile('picture')) {
            $picture_genba = $this->image_intervention($request->file('picture'), 'images/genba/' . $category);
        }

        $payload = [
            'installed_at'  => $dateNow,
            'picture_genba' => $picture_genba
        ];

        if ($category === 'edge_computing') {
            EdgeComputing::where('serial_number', $serial_number)->update($payload);
        } else if ($category === 'iot_node') {
            IOTNode::where('serial_number', $serial_number)->update($payload);
        }

        return response()->json(['status' => 'success']);
    }

    public function getDeviceSerialNumbers($category, $type = null)
    {
        $numbers = null;
        if ($category === 'edge_computing') {
            $numbers = EdgeComputing::query();
            if ($type === 'activate') $numbers = $numbers->whereNull('expired_at');
            $numbers = $numbers->pluck('serial_number')->toArray();
        } else if ($category === 'iot_node') {
            $numbers = IOTNode::query();
            if ($type === 'activate') $numbers = $numbers->whereNull('expired_at');
            $numbers = $numbers->pluck('serial_number')->toArray();
        }

        return implode(',', $numbers);
    }

    public function getUserIds()
    {
        return implode(',', User::pluck('id')->toArray());
    }

    public function image_intervention($image, $path)
{
    $name = strtoupper(Str::random(5)) . '-' . rand() . '-' . time() . '.jpg';

    if (!file_exists($path)) {
        mkdir($path, 0755, true);
    }

    $imageResize = Image::make($image->getRealPath());
    $imageResize->save($path . $name);

    return $path . $name;
}


    public function storeDataSensors(Request $request): JsonResponse
    {
        $request->validate([
            'iot_node_serial_number' => ['required', 'exists:i_o_t_nodes,serial_number'],
            'dissolver_oxygen' => ['required', 'numeric'],
            'turbidity' => ['required', 'numeric'],
            'salinity' => ['required', 'numeric'],
            'cod' => ['required', 'numeric'],
            'ph' => ['required', 'numeric'],
            'orp' => ['required', 'numeric'],
            'tds' => ['required', 'numeric'],
            'nitrat' => ['required', 'numeric'],
            'temperature_air' => ['required', 'numeric'],
            'debit_air' => ['required', 'numeric'],
            'tss' => ['required', 'numeric'],
            'water_level_cm' => ['required', 'numeric'],
            'water_level_persen' => ['required', 'numeric'],
            'status_pompa' => ['required', 'in:0,1']
        ]);

        MonitoringTelemetry::insert($request->only([
            'iot_node_serial_number',
            'dissolver_oxygen',
            'turbidity',
            'salinity',
            'cod',
            'ph',
            'orp',
            'tds',
            'nitrat',
            'temperature_air',
            'debit_air',
            'tss',
            'water_level_cm',
            'water_level_persen',
            'status_pompa',
        ]) + [
            'created_at' => now('Asia/Jakarta')
        ]);

        event(new MonitoringTelemetryEvent($request->iot_node_serial_number, $request->all(), now('Asia/Jakarta')));

        return response()->json([
            'message' => 'Data berhasil disimpan'
        ]);
    }

    public function newDashboard(Request $request, $id): JsonResponse
    {
         $monitoringTelemetry1 = MonitoringTelemetry::query()->with('treshold')
        ->where('iot_node_serial_number', $id)
        ->orderByDesc('created_at')
        ->limit(10)
        ->get();

        $monitoringTelemetry = MonitoringTelemetry::query()
        ->with('treshold')
        ->where('iot_node_serial_number', $id)
        ->whereRaw('MINUTE(created_at) % 5 = 0')
        ->where('created_at', '>=', now()->subDay())
        ->orderBy('created_at')
        ->get();

    $selectedData = collect($monitoringTelemetry)->groupBy(function ($item) {
        return $item->created_at->format('Y-m-d H:i');
    })->values()->toArray();

    $firstEntryForEachInterval = collect($selectedData)->map(function ($data) {
        return $data[0];
    });

    return response()->json([
        'latest' => (count($monitoringTelemetry1) > 0) ? $monitoringTelemetry1[0] : null,
        'data' => $firstEntryForEachInterval,
    ]);

    }

    public function checkEmail(Request $request) : JsonResponse {
        $request->validate([
            'email' => ['required', 'email']
        ]);

        $checkEmail = User::query()->where('role', '<>', 'su')->firstWhere('email', $request->email);

        if (!$checkEmail) {
            return response()->json([
                'message' => 'Email tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'email' => $request->email,
            'message' => 'Email terdaftar dalam sistem.'
        ]);
    }

    public function resetPassword(Request $request) : JsonResponse {
        $request->validate([
            'email' => ['required', 'email', 'exists:users,email'],
            'password' => ['required', 'string', 'min:8', 'max:255', 'confirmed']
        ]);

        $user = User::query()->where('role', '<>', 'su')->firstWhere('email', $request->email);

        $user->update([
            'password' => Hash::make($request->password)
        ]);

        return response()->json([
            'message'=> 'Kata sandi berhasil diubah, silahkan log in kembali!'
        ]);
    }
    public function getSensors(Request $request): JsonResponse
    {
        $sensor = Sensor::orderBy('id', 'asc')
        ->select('id', 'namaSensor')
        ->get();

        return response()->json([
            'status' => 'success',
            'data' => $sensor
        ]);
    }
    public function storeSensors(Request $request): JsonResponse
    {
        $request->validate([
            'namaSensor' => ['required', 'unique:sensors,namaSensor'],
        ]);

        Sensor::insert($request->only([
            'namaSensor',
        ]) + [
            'created_at' => now('Asia/Jakarta')
        ]);

        event(new MonitoringTelemetryEvent($request->namaSensor, $request->all(), now('Asia/Jakarta')));

        return response()->json([
            'message' => 'Data berhasil dibuat'
        ]);
    }
    public function updateSensor(Request $request, $id)
{
    $sensor = Sensor::findOrFail($id);
    $request->validate([
        'namaSensor' => 'required|unique:sensors,namaSensor,' . $id
    ]);
    $sensor->update(['namaSensor' => $request->input('namaSensor')]);

    return response()->json([
        'status' => 'success',
        'message' => 'Sukses update.'
    ]);
}
public function getTresholdWeb(Request $request): JsonResponse
    {
        $thresholds = Treshold::query()
        ->select('id', 'iot_node_serial_number', 'variable', 'value_min', 'value_max', 'rules','value')
        ->where('iot_node_serial_number', $request->iot_node_serial_number)
        ->get();

    return response()->json([
        'status' => 'success',
        'data' => $thresholds,
    ]);
    }
public function getTreshold(Request $request): JsonResponse
    {
        $thresholds = Treshold::query()
        ->select('id', 'iot_node_serial_number', 'variable', 'value_min', 'value_max', 'rules')
        ->where('iot_node_serial_number', $request->iot_node_serial_number)
        ->get();

    return response()->json([
        'status' => 'success',
        'data' => $thresholds,
    ]);
    }
    public function storeTreshold(Request $request): JsonResponse
{
    $validation = Validator::make($request->all(), [
        'iot_node_serial_number' => ['required', 'string'],
        'variable' => ['required', 'string'],
        'value_min' => ['required', 'numeric'],
        'value_max' => ['required', 'numeric'],
        'rules' => ['nullable', 'string'],
    ]);

    if ($validation->fails()) {
        return response()->json([
            'status' => 'fail',
            'message' => 'Data gagal dibuat. Periksa input Anda.',
            'errors' => $validation->errors(),
        ], Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    // Coba menyimpan data
    try {
        $threshold =  $treshold= Treshold::insert($request->only([
            'iot_node_serial_number',
            'variable',
            'value_min',
            'value_max',
            'rules'
        ]) + [
            'created_at' => now('Asia/Jakarta')
        ]);

        if ($threshold) {
            return response()->json([
                'status' => 'success',
                'message' => 'Data berhasil dibuat',
            ], Response::HTTP_CREATED);
        } else {
            return response()->json([
                'status' => 'fail',
                'message' => 'Data gagal dibuat!',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'fail',
            'message' => 'Terjadi kesalahan internal server.',
        ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}

public function updateTreshold(Request $request)
{
    try {
        $dataToUpdate = $request->all();

        foreach ($dataToUpdate as $key => $value) {
            $parts = explode('value_min', $key);

            if (count($parts) == 2) {
                $sensorName = $parts[1];

                Treshold::where('variable', $sensorName)->where('iot_node_serial_number', $request->iot_node_serial_number)
                ->update([
                    'value_min' => $value,
                ]);
            }

            $parts = explode('value_max', $key);

            if (count($parts) == 2) {
                $sensorName = $parts[1];
                Treshold::where('variable', $sensorName)->where('iot_node_serial_number', $request->iot_node_serial_number)
                ->update([
                    'value_max' => $value,
                ]);
            }
            $parts = explode('rules', $key);

            if (count($parts) == 2) {
                $sensorName = $parts[1];
                Treshold::where('variable', $sensorName)->where('iot_node_serial_number', $request->iot_node_serial_number)
                ->update([
                    'rules' => $value,
                ]);
            }
        }

        return response()->json(['status' => 'success', 'message' => 'Data berhasil diperbarui']);
    } catch (\Exception $e) {
        return response()->json(['status' => 'error', 'message' => 'Terjadi kesalahan saat mengupdate data.']);
    }}
public function getIotNode(Request $request): JsonResponse
    {
        $location = IOTNode::query()->with('edge_computing')
        ->select('id','lat','lng')
        ->where('edge_computing_id',$request->edge_computing_id)
        ->get();

        return response()->json([
            'status' => 'success',
            'data' => $location
        ]);
    }

}
