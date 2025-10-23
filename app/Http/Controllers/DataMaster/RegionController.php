<?php

namespace App\Http\Controllers\DataMaster;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Region;

use App\Http\Requests\DataMaster\Region\GlobalRequest;

class RegionController extends Controller
{
    public function __construct () {
        $this->view = 'pages.data_master.region.';
        $this->route = 'region.';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $payload['route'] = $this->route;
        $payload['data']  = Region::with('cities')->get();

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
    public function store(GlobalRequest $request)
    {
        Region::create(['name' => $request->name]);
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
        $payload['data'] = Region::findOrFail($id);

        return view($this->view . 'edit', $payload);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(GlobalRequest $request, $id)
    {
        Region::findOrFail($id)->update(['name' => $request->name]);
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
        if (!Region::destroy($id)){
            return redirect()->back()->with('Gagal', 'destroy');
        }
        // $data = Region::findOrFail($id);
        // $data->delete();
        return redirect()->route($this->route . 'index')->with('success', 'destroy');
    }
}
