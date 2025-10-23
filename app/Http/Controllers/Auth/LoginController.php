<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use App\Models\ActivityLog;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;
    protected function authenticated($request, $user)
{
    ActivityLog::create([
        'user_id' => $user->id,
        'waktu' => now(),
        'status' => 'Login.',
    ]);
    return redirect('/dashboard');
}

public function logout(Request $request)
{
    ActivityLog::create([
        'user_id' => auth()->user()->id,
        'waktu' => now(),
        'status' => 'Logout.',
    ]);

    $this->guard()->logout();
    // $request->session()->invalidate();
    // $request->session()->regenerateToken();
    return redirect('/');
}


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
