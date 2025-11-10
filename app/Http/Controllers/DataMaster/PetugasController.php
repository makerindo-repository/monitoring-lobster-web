<?php

namespace App\Http\Controllers\DataMaster;

use App\Http\Controllers\Controller;
use App\Models\Petugas;
use Illuminate\Http\Request;

class PetugasController extends Controller
{
    public $view;
    public $route;

    public function __construct()
    {
        $this->view = 'pages.data_master.petugas.';
        $this->route = 'petugas.';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $payload['route'] = $this->route;
        $payload['data'] = Petugas::paginate(20);

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
            'nama' => 'required|string',
            'nomor_telepon' => 'required|max:15|unique:petugas,nomor_telepon',
            'alamat' => 'required|string',
        ], [
            'nama.required' => 'Nama Petugas wajib diisi',
            'nomor_telepon.required' => 'Nomor Telepon wajib diisi',
            'nomor_telepon.max' => 'Nomor Telepon maksimal 15 digit',
            'nomor_telepon.unique' => 'Nomor Telepon ini sudah terdaftar',
            'alamat.required' => 'Alamat wajib diisi',
        ]);

        Petugas::create([
            'nama' => $request->nama,
            'nomor_telepon' => $request->nomor_telepon,
            'alamat' => $request->alamat,
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
        $payload['data'] = Petugas::findOrFail($id);
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
            'nama' => 'required|string',
            'nomor_telepon' => 'required|max:15|unique:petugas,nomor_telepon,' . $id,
            'alamat' => 'required|string',
        ], [
            'nama.required' => 'Nama Petugas wajib diisi',
            'nomor_telepon.required' => 'Nomor Telepon wajib diisi',
            'nomor_telepon.max' => 'Nomor Telepon maksimal 15 digit',
            'nomor_telepon.unique' => 'Nomor Telepon ini sudah terdaftar',
            'alamat.required' => 'Alamat wajib diisi',
        ]);

        $petugas = Petugas::findOrFail($id);
        $petugas->update([
            'nama' => $request->nama,
            'nomor_telepon' => $request->nomor_telepon,
            'alamat' => $request->alamat,
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
        if (!Petugas::destroy($id)) {
            return redirect()->back()->with('Gagal', 'destroy');
        }

        return redirect()->route($this->route . 'index')->with('success', 'destroy');
    }
}
