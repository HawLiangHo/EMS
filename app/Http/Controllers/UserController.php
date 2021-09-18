<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Events;
use App\Notifications\AdminCreatedNotification;
use App\Rules\MatchOldPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function __construct()
    {
        // $this->middleware(['auth']);
        // $this->middleware(['admin'])->only(["dashboard"]);
        // $this->middleware(['participant']);
    }

    public function editProfile(){
        $users = DB::table('users')->get();
        $users = DB::select('SELECT * FROM users WHERE id = '.Auth::id().'');

        return view('editProfile',['users' => $users[0]]);
    }

    public function updateProfile(Request $request){
        $id = Auth::user()->id;

        $this->validate(
            $request,[
                'username' => 'required|max:255|unique:users,username,'.$id.'',
                'email' => 'required|email|max:255|unique:users,email,'.$id.'',
                'phone' => 'required|regex:/^(\+6)?01[0-46-9]-[0-9]{7,8}$/|max:14',
                'address' => 'max:255'

        ]);
        $user = User::findOrFail($id);
        $user->username = request('username');
        $user->email = request('email');
        $user->phone = request('phone');
        $user->address = request('address');
        $user->save();

        return redirect()->route('editProfile')->with('message', 'Profile details updated successfully');
    }

    public function openChangePassword(){
        return view("changePassword");
    }

    public function changePassword(Request $request) {
        $this->validate($request, [
            'oldPassword' => [new MatchOldPassword],
            'password' => 'required|confirmed|min:4|max:255',
        ]);
        User::find(auth()->user()->id)->update(['password'=> Hash::make($request->password)]);
        return redirect()->route("changePassword")->with("status", "Your password has updated successfully");
    }

    public function openBilling(){
        $users = DB::table('users')->get();
        $users = DB::select('SELECT * FROM users WHERE id = '.Auth::id().'');

        return view('billing',['users' => $users[0]]);
    }

    public function reloadCreditPage(){
        $users = DB::table('users')->get();
        $users = DB::select('SELECT * FROM users WHERE id = '.Auth::id().'');

        return view('reloadCredit',['users' => $users[0]]);
    }

    public function reloadCreditAction(Request $request){
        $this->validate(
            $request,[
                'amount' => 'required|numeric|min:5|max:1500',
                'ccn' => 'required|max:19',
                'month' => 'required',
                'year' => 'required',
                'cvv' => 'required'
        ]);

        $message = "";
        if($request->amount < 5 || $request->amount > 1500){
            $message = "Invalid transaction!";
            return redirect()->route('reloadCredit')->with('message',$message);
        }
        else{
            $user = User::find(Auth::id());

            $total_reload = $request->amount + $user->credit_balance;
            $user->credit_balance = $total_reload;
            $user->save();
            $message = "Reload credit successfully";
    
            return redirect('/billing')->with('message',$message);
        }
    }

    public function myTickets(){
        $users = DB::table('users')->get();
        $users = DB::select('SELECT * FROM users WHERE id = '.Auth::id().'');

        return view('myTickets',['users' => $users[0]]);
    }

}
