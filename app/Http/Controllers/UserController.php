<?php

namespace App\Http\Controllers;

use Hash;

use App\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\RolePermissions;
use Intervention\Image\ImageManagerStatic as Image;

class UserController extends Controller
{
    public function __construct() {
        $this->view  = 'pages.user.';
        $this->route = 'user.';
        $this->views  = 'pages.role_permissions.';
        $this->routes = 'petugas.';
    }

    public function index()
    {
        $payload['route'] = $this->route;
        $payload['routes'] = $this->routes;
        $payload['permissions'] = RolePermissions::all();
        $payload['data']  = User::where('role', '!=', 'su')->get();

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
            'name'     => 'required|max:100',
            'email'    => 'required|email|unique:users',
            'password' => ['required', 'min:6', 'regex:/[0-9]/', 'regex:/[^a-zA-Z0-9 ]/']
        ]);

        $picture = null;
        if ($request->hasFile('picture')) {
            $picture = $this->image_intervention($request->file('picture'), 'images/user/');
        }

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'role'     => 'petugas',
            'password' => Hash::make($request->password),
            'picture'  => $picture
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
        $payload['data'] = User::findOrFail($id);

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
        $data = User::findOrFail($id);

        $request->validate([
            'name'     => 'required|max:100',
            'email'    => 'required|email|unique:users,email,' . $id,
            'password' => ['nullable', 'min:6', 'regex:/[0-9]/', 'regex:/[^a-zA-Z0-9 ]/']
        ]);

        $data->update([
            'name'     => $request->name,
            'email'    => $request->email,
            'role'     => 'petugas',
        ]);

        if ($request->has('password') && !empty($request->password)) {
            $data->update([
                'password' => Hash::make($request->password)
            ]);
        }

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
        User::findOrfail($id)->delete();
        return back()->with('success', 'destroy');
    }

    public function image_intervention($image, $path, $w = 300, $h = 290) {
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
