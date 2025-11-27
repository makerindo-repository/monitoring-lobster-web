<?php

namespace App\Http\Controllers\DataMaster;

use App\Http\Controllers\Controller;
use App\Models\Kja;
use App\Models\LogPakan;
use App\Models\Petugas;
use Illuminate\Http\Request;

class FeedController extends Controller
{
    public $view;
    public $route;

    public function __construct()
    {
        $this->view = 'pages.data_master.feed.';
        $this->route = 'feed.';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $payload['route'] = $this->route;
        $payload['data'] = LogPakan::with('petugas', 'kja')->paginate(20);

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
        $payload['petugas'] = Petugas::get();
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
            'pemberian_ke' => 'required|integer|unique:log_pakans,pemberian_ke',
            'jenis_pakan' => 'required|string',
            'berat' => 'required|integer',
            'petugas' => 'required|integer',
            'kja' => 'required|integer',
        ], [
            'pemberian_ke.required' => 'Pemberian wajib diisi',
            'pemberian_ke.integer' => 'Format Pemberian tidak valid',
            'pemberian_ke.unique' => 'Data Pemberian Ke-' . $request->pemberian_ke . ' sudah ada',
            'jenis_pakan.required' => 'Jenis Pakan wajib diisi',
            'berat.required' => 'Berat wajib diisi',
            'berat.integer' => 'Format Berat tidak valid',
            'petugas.required' => 'Petugas wajib diisi',
            'petugas.integer' => 'Format Petugas tidak valid',
            'kja.required' => 'KJA wajib diisi',
            'kja.integer' => 'Format KJA tidak valid',
        ]);

        LogPakan::create([
            'pemberian_ke' => $request->pemberian_ke,
            'jenis_pakan' => $request->jenis_pakan,
            'berat' => $request->berat,
            'petugas_id' => $request->petugas,
            'kja_id' => $request->kja,
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
        $payload['data'] = LogPakan::findOrFail($id);
        $payload['petugas'] = Petugas::get();
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
            'pemberian_ke' => 'required|integer|unique:log_pakans,pemberian_ke,' . $id,
            'jenis_pakan' => 'required|string',
            'berat' => 'required|integer',
            'petugas' => 'required|integer',
            'kja' => 'required|integer',
        ], [
            'pemberian_ke.required' => 'Pemberian wajib diisi',
            'pemberian_ke.integer' => 'Format Pemberian tidak valid',
            'pemberian_ke.unique' => 'Data Pemberian Ke-' . $request->pemberian_ke . ' sudah ada',
            'jenis_pakan.required' => 'Jenis Pakan wajib diisi',
            'berat.required' => 'Berat wajib diisi',
            'berat.integer' => 'Format Berat tidak valid',
            'petugas.required' => 'Petugas wajib diisi',
            'petugas.integer' => 'Format Petugas tidak valid',
            'kja.required' => 'KJA wajib diisi',
            'kja.integer' => 'Format KJA tidak valid',
        ]);

        $logPakan = LogPakan::findOrFail($id);
        $logPakan->update([
            'pemberian_ke' => $request->pemberian_ke,
            'jenis_pakan' => $request->jenis_pakan,
            'berat' => $request->berat,
            'petugas_id' => $request->petugas,
            'kja_id' => $request->kja,
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
        if (!LogPakan::destroy($id)) {
            return redirect()->back()->with('Gagal', 'destroy');
        }

        return redirect()->route($this->route . 'index')->with('success', 'destroy');
    }
}
