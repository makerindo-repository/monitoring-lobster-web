<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RolePermissions;
use App\Http\Controllers\Controller;

class RolePermissionsController extends Controller
{
    public function __construct() {
        $this->view  = 'pages.role_permissions.';
        $this->route = 'petugas.';

        $this->views  = 'pages.user.';
        $this->routes = 'user.';
    }
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('pages.role_permissions.create');
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
            'name'     => 'required',
            ]);

        RolePermissions::create([
            'name'     => $request->name,

        ]);

        return redirect()->route($this->routes . 'index')->with('success', 'store');
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
   public function update(Request $request)
{
    $permissions = $request->input('permissions');

    if ($permissions) {
        foreach ($permissions as $id => $data) {
            $rolePermission = RolePermissions::findOrFail($id);

            // Update status user, petugas, dan direksi berdasarkan nilai yang dikirimkan dari formulir
            $rolePermission->user = isset($data['user']);
            $rolePermission->petugas = isset($data['petugas']);
            $rolePermission->direksi = isset($data['direksi']);

            // Simpan perubahan
            $rolePermission->save();
        }
    }

    return back()->with('success', 'update');
}


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       $rolePermission = RolePermissions::findOrfail($id);
       $rolePermission->delete();
        return back()->with('success', 'destroy');

    }
}
