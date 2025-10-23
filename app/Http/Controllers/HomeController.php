<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function default () {
        return redirect('/dashboard');
    }

    public function debug() {
        return view('pages.debug');
    }
}
