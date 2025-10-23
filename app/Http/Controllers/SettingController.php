<?php

namespace App\Http\Controllers;

use App\Models\Sensor;
use App\Models\IOTNode;
use App\Models\Setting;

use App\Models\Treshold;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function __construct(Setting $setting) {
        $this->setting = $setting;
        $this->view = 'pages.setting';

    }

    public function index() {
        $treshold = Treshold::with('sensors')->get();
        $nodes = IOTNode::query()
            ->whereNotNull('activated_at')
            ->pluck('serial_number');
        return view($this->view, [
            'data'      => $this->setting::first(),
            'treshold' => $treshold,
            'nodes' => $nodes,
        ]);
    }


    public function update(Request $request) {

        $setting = $this->setting::first();
        $setting->update(
            $request->only('name', 'description', 'version', 'copyright', 'pt_name')
        );

        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $fileName = 'LOGO_'.strtoupper(Str::random(5)) . '-' . rand() . '-' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/'), 'images/' . $fileName);

            $setting->update([
                'logo' => 'images/'.$fileName
            ]);
        }

        return back()->with('success', 'update');
    }

    public function updateTresholds(Request $request) {

        $ids = $request->input('id');
        $valueMins = $request->input('value_min');
        $valueMaxs = $request->input('value_max');
        $rules = $request->input('rules');
        $values = $request->input('value');

        foreach ($ids as $key => $id) {
            Treshold::where('id', $id)->update([
                'value_min' => $valueMins[$key],
                'value_max' => $valueMaxs[$key],
                // 'rules' => $rules[$key],
                'value' => $values[$key],
            ]);
        }
        return back()->with('success', 'update');
    }

    public function createTreshold(){
        $sensor = Sensor::all();
        $nodes = IOTNode::query()
            ->whereNotNull('activated_at')
            ->pluck('serial_number');
        return view('pages.treshold.create',compact('sensor','nodes'));

    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'iot_node_serial_number' => 'required',
            'variable' => 'required',
        ]);

        $treshold = new Treshold();
        $treshold->iot_node_serial_number = $request->iot_node_serial_number;
        $treshold->variable = $request->variable;
        $treshold->value_min = $request->value_min;
        $treshold->value_max = $request->value_max;
        // $treshold->rules = $request->rules;

        $treshold->save();
        return redirect( 'setting')->with('success');

    }
    public function deleteTreshold($id){
        $treshold = Treshold::findOrFail($id);
        $treshold->delete();

        return back()->with('success', 'destroy');

    }

}
