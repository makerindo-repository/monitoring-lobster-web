<?php

namespace App\Http\Controllers\DataMaster;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\City;
use App\Models\Region;

use App\Http\Requests\DataMaster\City\GlobalRequest;

class CityController extends Controller
{
    public function __construct () {
        $this->view = 'pages.data_master.city.';
        $this->route = 'city.';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = City::with('region');

        /*
            Searching & Filtering
        */
        if ($request->has('search') && !empty($request->search)) {
            $key = '%' . trim($request->search) . '%';
            $data = $data->where('name', 'LIKE', $key);
        }
        if ($request->has('region') && !empty($request->region) && $request->region != "all") {
            $key = trim($request->region);
            $data = $data->whereHas('region', function ($q) use ($key) {
                $q->where('name', $key);
            });
        }

        $payload['route']   = $this->route;
        $payload['regions'] = $this->getRegions();
        $payload['data']    = $data->paginate(20);

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
        $payload['regions'] = $this->getRegions();

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
        City::create($request->only('region_id', 'name'));
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
        $payload['route']   = $this->route;
        $payload['data']    = City::findOrFail($id);
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
    public function update(GlobalRequest $request, $id)
    {
        City::findOrFail($id)->update($request->only('region_id', 'name'));
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
        $data = City::findOrFail($id);
        $data->delete();

        return redirect()->route($this->route . 'index')->with('success', 'destroy');
    }

    public function getRegions () {
        return Region::pluck('name', 'id')->toArray();
    }

}
