<?php

namespace App\Http\Controllers\DataMaster;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Camera;
use App\Models\Kja;

class CameraController extends Controller
{
    public function __construct()
    {
        $this->view = 'pages.data_master.camera.';
        $this->route = 'camera.';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $payload['route'] = $this->route;
        $payload['data'] = Camera::with('kja')->paginate(20);

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
        $payload['kja'] = Kja::get();
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
            'id_kamera' => 'required|unique:cameras,id_kamera',
            'kja_id' => 'required|exists:kja,id',
            'ip_kamera' => 'required|unique:cameras,ip_kamera',
            'status' => 'required|boolean',
        ], [
            'id_kamera.required' => 'ID Kamera wajib diisi',
            'id_kamera.unique' => 'ID Kamera sudah ada',
            'kja_id.required' => 'KJA wajib diisi',
            'kja_id.exists' => 'KJA tidak ditemukan',
            'ip_kamera.required' => 'IP Kamera wajib diisi',
            'ip_kamera.unique' => 'IP Kamera sudah ada',
            'status.required' => 'Status wajib diisi',
            'status.boolean' => 'Status harus berupa boolean',
        ]);

        Camera::create([
            'id_kamera' => $request->id_kamera,
            'kja_id' => $request->kja_id,
            'ip_kamera' => $request->ip_kamera,
            'status' => $request->status,
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
        $payload['data'] = Camera::findOrFail($id);
        $payload['kja'] = Kja::get();
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
            'id_kamera' => 'required|unique:cameras,id_kamera,' . $id,
            'kja_id' => 'required|exists:kja,id',
            'ip_kamera' => 'required|unique:cameras,ip_kamera,' . $id,
            'status' => 'required|boolean',
        ], [
            'id_kamera.required' => 'ID Kamera wajib diisi',
            'id_kamera.unique' => 'ID Kamera sudah ada',
            'kja_id.required' => 'KJA wajib diisi',
            'kja_id.exists' => 'KJA tidak ditemukan',
            'ip_kamera.required' => 'IP Kamera wajib diisi',
            'ip_kamera.unique' => 'IP Kamera sudah ada',
            'status.required' => 'Status wajib diisi',
            'status.boolean' => 'Status harus berupa boolean',
        ]);

        $camera = Camera::findOrFail($id);
        $camera->update([
            'id_kamera' => $request->id_kamera,
            'kja_id' => $request->kja_id,
            'ip_kamera' => $request->ip_kamera,
            'status' => $request->status,
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
        if (!Camera::destroy($id)) {
            return redirect()->back()->with('Gagal', 'destroy');
        }

        return redirect()->route($this->route . 'index')->with('success', 'destroy');
    }
}
