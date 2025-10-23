<?php

namespace App\Http\Controllers\DataMaster;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EdgeComputing;
use App\Models\IOTNode;
use App\Models\Region;
use App\Models\City;

use App\Http\Requests\DataMaster\EdgeComputing\StoreRequest;
use App\Http\Requests\DataMaster\EdgeComputing\UpdateRequest;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Str;
use Spatie\Activitylog\Contracts\Activity;

class EdgeComputingController extends Controller
{
    public function __construct()
    {
        $this->view = 'pages.data_master.edge_computing.';
        $this->route = 'edge-computing.';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $data = EdgeComputing::with('city.region');

        /*
            Searching & Filtering
        */
        if ($request->has('search') && !empty($request->search)) {
            $key = '%' . trim($request->search) . '%';
            $data = $data->where('serial_number', 'LIKE', $key)
                ->orWhereHas('city', function ($q) use ($key) {
                    $q->where('name', 'LIKE', $key);
                })
                ->orWhereHas('city.region', function ($q) use ($key) {
                    $q->where('name', 'LIKE', $key);
                });
        }

        if ($request->has('filter')) {
            $filter = $request->filter;
            if ($filter == 2) $data = $data->whereNotNull('activated_by');
            if ($filter == 3) $data = $data->whereNull('activated_by');
        }

        $payload['route'] = $this->route;
        $payload['data']  = $data->paginate(9);

        return view($this->view . 'index', $payload);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $payload['route']  = $this->route;
        $payload['regions'] = $this->getRegions();

        return view($this->view . 'create', $payload);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {

        // kode + provinsi + kota + tahun dibuat +nomor regis
        // ED010322001
        $latest_serial_number = EdgeComputing::latest()->pluck('serial_number')->first();
        $last_digits = substr($latest_serial_number, -3);

        $city = City::findOrFail($request->city_id);
        $city_code = $city->code;
        $region_code = $city->region->code;

        // Fixed serial number
        $serial_number = ('ED' . $city_code . $region_code . now()->format('y') . sprintf('%03d', ((int)$last_digits) + 1));

        $picture = null;
        if ($request->hasFile('picture')) {
            $picture = $this->image_intervention($request->file('picture'), 'images/edge_computing/');
        }

        $edge = EdgeComputing::create(
            array_merge(
                $request->only('city_id', 'memory', 'processor_clock_speed', 'os', 'framework', 'power_supply', 'ip', 'ip_gateway', 'voltage', 'maximum_iot'),
                [
                    'picture' => $picture,
                    'serial_number' => $serial_number
                ]
            )
        );

        for ($i = 1; $i <= (int) $request->maximum_iot; $i++) {
            IOTNode::create([
                'city_id' => $request->city_id,
                'edge_computing_id' => $edge->id,
                'edge_computing_node' => $i,
                'serial_number' => $serial_number . 'NODE' . sprintf('%03d', $i),
                'user_id' => auth()->user()->id
            ]);
        }

        return redirect()->route($this->route . 'index')->with('success', 'store');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $payload['data']  = EdgeComputing::with('city.region')->whereId($id)->firstOrFail();
        $payload['route'] = $this->route;

        return view($this->view . 'show', $payload);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $payload['data']    = EdgeComputing::with('city.region')->whereId($id)->firstOrFail();
        $payload['route']   = $this->route;
        $payload['regions'] = $this->getRegions();

        return view($this->view . 'edit', $payload);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, $id)
    {
        $data = EdgeComputing::findOrFail($id);

        $old_picture = $data->picture;
        if ($request->hasFile('picture')) {
            $picture = $this->image_intervention($request->file('picture'), 'images/edge_computing/');
            if ($old_picture) {
                $old_picture = public_path($old_picture);
                if ($old_picture) unlink($old_picture);
            }
        } else {
            $picture = $old_picture;
        }

        $data->update(
            array_merge(
                $request->only('city_id', 'serial_number', 'memory', 'processor_clock_speed', 'os', 'framework', 'power_supply', 'ip', 'ip_gateway', 'voltage', 'maximum_iot'),
                [
                    'picture' => $picture
                ]
            )
        );

        return redirect()->route($this->route . 'index')->with('success', 'update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!EdgeComputing::destroy($id)){
            return redirect()->back()->with('Gagal', 'destroy');
        }else{
            return redirect()->route($this->route . 'index')->with('success', 'destroy');
        }
        // $data = EdgeComputing::findOrFail($id);

        // if ($data->picture) {
        //     $picture = public_path($data->picture);
        //     if (file_exists($picture)) unlink($picture);
        // }

        // if ($data->picture_genba) {
        //     $picture_genba = public_path($data->picture_genba);
        //     if (file_exists($picture_genba)) unlink($picture_genba);
        // }

        // $data->delete();

        // return redirect()->route($this->route . 'index')->with('success', 'destroy');
    }

    public function getRegions()
    {
        return Region::with(['cities' => function ($city) {
            $city->select('id', 'region_id', 'name');
        }])->select('id', 'name')->get();
    }

    public function image_intervention($image, $path, $w = 500, $h = 400)
    {
        $name = strtoupper(Str::random(5)) . '-' . rand() . '-' . time() . '.' . $image->getClientOriginalExtension();
        $imageResize = Image::make($image->getPathName());

        $imageResize->height() > $imageResize->width() ? $w = null : $h = null;
        $imageResize->resize($w, $h, function ($constraint) {
            $constraint->aspectRatio();
        });

        if (!file_exists($path)) {
            mkdir($path, 666, true);
        }

        $imageResize->save(public_path($path . $name));

        return $path . $name;
    }
}
