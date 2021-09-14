<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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

    public function __construct()
    {
        $this->middleware(['guest']);
    }

    public function index()
    {
        return view("auth.login");
    }
    

    public function store(Request $request)
    {
        $this->validate($request, [
            "username" => "required|max:255",
            "password" => "required"
        ]);

        if (!auth()->attempt($request->only('username', 'password'), $request->remember)) {
            return redirect()->route("login")->withInput()->with("status", "Invalid login details");
        }
        
        return redirect()->route("home");
    }
}
