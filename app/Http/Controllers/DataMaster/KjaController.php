<?php

namespace App\Http\Controllers\DataMaster;

use App\Http\Controllers\Controller;
use App\Models\Kja;
use Illuminate\Http\Request;

class KjaController extends Controller
{
    public function __construct()
    {
        $this->view = 'pages.data_master.kja.';
        $this->route = 'kja.';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $payload['route'] = $this->route;
        $payload['data'] = Kja::paginate(20);
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
        $request->validate([
            'nomor_kja' => 'required|unique:kja,nomor_kja',
            'latitude' => 'required',
            'longitude' => 'required',
            'dimensi' => 'required|numeric|min:0',
            'kondisi' => 'required',
        ], [
            'nomor_kja.required' => 'Nomor KJA wajib diisi',
            'nomor_kja.unique' => 'Nomor KJA sudah ada',
            'latitude.required' => 'Latitude wajib diisi',
            'longitude.required' => 'Longitude wajib diisi',
            'dimensi.required' => 'Dimensi wajib diisi',
            'dimensi.numeric' => 'Dimensi harus berupa angka',
            'dimensi.min' => 'Dimensi harus lebih dari 0',
            'kondisi.required' => 'Kondisi wajib diisi',
        ]);

        Kja::create([
            'nomor_kja' => $request->nomor_kja,
            'latitude' => trim($request->latitude),
            'longitude' => trim($request->longitude),
            'dimensi' => $request->dimensi,
            'kondisi' => $request->kondisi,
        ]);

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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $payload['route'] = $this->route;
        $payload['data'] = Kja::findOrFail($id);

        return view($this->view . 'edit', $payload);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nomor_kja' => 'required|unique:kja,nomor_kja,' . $id,
            'latitude' => 'required',
            'longitude' => 'required',
            'dimensi' => 'required|numeric|min:0',
            'kondisi' => 'required',
        ], [
            'nomor_kja.required' => 'Nomor KJA wajib diisi',
            'nomor_kja.unique' => 'Nomor KJA sudah ada',
            'latitude.required' => 'Latitude wajib diisi',
            'longitude.required' => 'Longitude wajib diisi',
            'dimensi.required' => 'Dimensi wajib diisi',
            'dimensi.numeric' => 'Dimensi harus berupa angka',
            'dimensi.min' => 'Dimensi harus lebih dari 0',
            'kondisi.required' => 'Kondisi wajib diisi',
        ]);

        $kja = Kja::findOrFail($id);

        $kja->update([
            'nomor_kja' => $request->nomor_kja,
            'latitude' => trim($request->latitude),
            'longitude' => trim($request->longitude),
            'dimensi' => $request->dimensi,
            'kondisi' => $request->kondisi,
        ]);

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
        if (!Kja::destroy($id)) {
            return redirect()->back()->with('Gagal', 'destroy');
        }

        return redirect()->route($this->route . 'index')->with('success', 'destroy');
    }
}
