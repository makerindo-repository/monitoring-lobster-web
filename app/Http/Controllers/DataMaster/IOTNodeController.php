<?php

namespace App\Http\Controllers\DataMaster;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EdgeComputing;
use App\Models\IOTNode;
use App\Models\Region;

use App\Http\Requests\DataMaster\IOTNode\StoreRequest;
use App\Http\Requests\DataMaster\IOTNode\UpdateRequest;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Str;
use Spatie\Activitylog\Contracts\Activity;

class IOTNodeController extends Controller
{
    public function __construct () {
        $this->view = 'pages.data_master.iot_node.';
        $this->route = 'iot-node.';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $data = IOTNode::with(['edge_computing', 'city.region']);

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

        // dd($payload);

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
        $payload['edges'] = $this->getEdges();

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
        $picture = null;
        if ($request->hasFile('picture')) {
            $picture = $this->image_intervention($request->file('picture'), 'images/iot_node/');
        }

        IOTNode::create([
            'city_id'                 => $request->city_id,
            'user_id'                 => auth()->user()->id,
            'edge_computing_id'       => $request->edge_computing_id,
            'edge_computing_node'     => $request->edge_computing_node,
            'serial_number'           => $request->serial_number,
            'picture'                 => $picture
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
        $payload['data']  = IOTNode::with(['city.region', 'edge_computing'])->whereId($id)->firstOrFail();
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
        $payload['data']    = IOTNode::with(['city.region', 'edge_computing'])->whereId($id)->firstOrFail();
        $payload['route']   = $this->route;
        $payload['regions'] = $this->getRegions();
        $payload['edges']   = $this->getEdges();

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
        $data = IOTNode::findOrFail($id);

        $old_picture = $data->picture;
        if ($request->hasFile('picture')) {
            $picture = $this->image_intervention($request->file('picture'), 'images/iot_node/');
            if ($old_picture) {
                $old_picture = public_path($old_picture);
                if ($old_picture) unlink($old_picture);
            }
        } else {
            $picture = $old_picture;
        }

        $data->update([
            'city_id'                 => $request->city_id,
            'user_id'                 => auth()->user()->id,
            'edge_computing_id'       => $request->edge_computing_id,
            'edge_computing_node'     => $request->edge_computing_node,
            'serial_number'           => $request->serial_number,
            'picture'                 => $picture
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
        if (!IOTNode::destroy($id)){
            return redirect()->back()->with('Gagal', 'destroy');
        }else{
            return redirect()->route($this->route . 'index')->with('success', 'destroy');
        }
        // $data = IOTNode::findOrFail($id);
        // if ($data->picture) {
        //     $picture = public_path($data->picture);
        //     if (file_exists($picture)) unlink($picture);
        // }
        // if ($data->picture_genba) {
        //     $picture_genba = public_path($data->picture_genba);
        //     if (file_exists($picture_genba)) unlink($picture_genba);
        // }
        // $data->delete();

    }

    public function getRegions () {
        return Region::with(['cities' => function ($city) {
                        $city->select('id', 'region_id', 'name');
               }])->select('id', 'name')->get();
    }

    public function getEdges () {
        return EdgeComputing::select('id', 'serial_number')->orderBy('serial_number', 'ASC')->get();
    }

    public function image_intervention ($image, $path, $w = 500, $h = 400) {
        $name = strtoupper(Str::random(5)).'-'.rand().'-'.time().'.'.$image->getClientOriginalExtension();
        $imageResize = Image::make($image->getPathName());

        $imageResize->height() > $imageResize->width() ? $w = null : $h = null;

        $imageResize->resize($w, $h, function($constraint){
            $constraint->aspectRatio();
        });

        if (!file_exists($path)) {
            mkdir($path, 666, true);
        }

        $imageResize->save(public_path($path . $name));

        return $path . $name;
    }

}
