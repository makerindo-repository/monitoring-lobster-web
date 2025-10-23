<?php

namespace App\Http\Controllers\DataMaster;
use App\Models\Sensor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SensorController extends Controller
{
    public function __construct () {
        $this->view = 'pages.data_master.sensor.';
        $this->route = 'sensor.';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $payload['route'] = $this->route;
        $payload['data']  = Sensor::paginate(20);

        return view($this->view . 'index', $payload);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $payload['route'] = $this->route;
        return view($this->view . 'create', $payload);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'namaSensor' => 'required|unique:sensors',
        ]);

        $sensor = new Sensor();
        $sensor->namaSensor = $request->namaSensor;
        $sensor->rentangNilai = $request->rentangNilai;
        $sensor->keterangan = $request->keterangan;

        $sensor->save();
        return redirect()->route($this->route . 'index')->with('success', 'store');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Sensor  $sensor
     * @return \Illuminate\Http\Response
     */
    public function show(Sensor $sensor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Sensor  $sensor
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $payload['route'] = $this->route;
        $payload['data'] = Sensor::findOrFail($id);

        return view($this->view . 'edit', $payload);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Sensor  $sensor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

    $sensor = Sensor::findOrFail($id);

    $rules = [
        'namaSensor' => 'required',
        'rentangNilai' => 'required',
        'keterangan' => 'required',
    ];

    $validasiData = $request->validate($rules);

    $sensor->namaSensor = $request->namaSensor;
    $sensor->rentangNilai = $request->rentangNilai;
    $sensor->keterangan = $request->keterangan;

    $sensor->save();

        return redirect()->route($this->route . 'index')->with('success', 'update');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Sensor  $sensor
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!Sensor::destroy($id)){
            return redirect()->back()->with('Gagal', 'destroy');
        }
        return redirect()->route($this->route . 'index')->with('success', 'destroy');
    }
}
