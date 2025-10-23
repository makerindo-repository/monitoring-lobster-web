<?php

namespace App\Http\Controllers;

use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function __construct() {
        $this->view = 'pages.profile';
    }

    public function index() {
        return view($this->view);
    }

    public function update(Request $request) {
        $id = auth()->user()->id;
        $data = User::findOrFail($id);

        $request->validate([
            'name'     => 'required|max:100',
            'email'    => 'required|email|unique:users,email,' . $id,
            'password' => ['nullable', 'min:6', 'regex:/[0-9]/', 'regex:/[^a-zA-Z0-9 ]/'],
            'picture'  => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data->update([
            'name'  => $request->name,
            'email' => $request->email,
        ]);

        if ($request->has('password') && !empty($request->password)) {
            $data->update([
                'password' => Hash::make($request->password)
            ]);
        }

        if($request->file('picture'))
        {
            $file = $request->file('picture');
            $dt = Carbon::now();
            $acak  = $file->getClientOriginalExtension();
            $fileName = rand(11111,99999).'-'.$dt->format('Y-m-d-H-i-s').'.'.$acak;
            $request->file('picture')->move("images/user", $fileName);
            $data->picture = $fileName;

            $data->update([
                'picture' => $fileName,
            ]);
        }

        return back()->with('success', 'update');
    }
}
