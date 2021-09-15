<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\Assistant;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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

    public function __construct()
    {
        // $this->middleware(['guest']);
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


        // if(auth()->user()->isAssistant()){
        //     return redirect()->route("manageEvents");
        // }
        // else{
        //     return redirect()->route("home");
        // }
        return redirect()->route("home");
        
    }

    public function assistantLogin(){
        return view('assistantLogin');
    }

    public function assistantLoginAction(Request $request){
        $this->validate($request, [
            "username" => "required|max:255",
            "password" => "required"
        ]);

        if (!auth()->attempt($request->only('username', 'password'), $request->remember)) {
            return redirect()->route("assistantLogin")->withInput()->with("status", "Invalid login details");
        }

        return redirect()->route("manageEvents");
    }
}
