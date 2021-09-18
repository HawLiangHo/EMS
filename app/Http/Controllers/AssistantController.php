<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Events;
use App\Models\Assistant;
use App\Notifications\AdminCreatedNotification;
use App\Rules\MatchOldPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AssistantController extends Controller
{

    public function manageUsers($id){
        $events = Events::findOrFail($id);
        $assistants = Assistant::all()->where('event_id', $id);

        return view('manageUsers', ['assistants' => $assistants, 'events' => $events]);
    }

    public function addUsersPage($id){
        $events = Events::findOrFail($id);

        return view('addUsers', ['events' => $events]);
    }

    public function createAssistant(Request $request, $id){
        $this->validate(
            $request,
            [
                'username' => 'required|max:255|unique:users,username,'.$id.'',
                'email' => 'required|email|max:255|unique:users,email,'.$id.'',
                'phone' => 'required|regex:/^(\+6)?01[0-46-9]-[0-9]{7,8}$/|max:14',
                'password' => 'required|confirmed|min:4|max:255',
            ]);
        
        $assistant = new Assistant();
        $assistant->event_id = $id;
        $assistant->username = request('username');
        $assistant->email = request('email');
        $assistant->phone = request('phone');
        $assistant->password = Hash::make(request('password'));
        $assistant->role = 2;
        $assistant->save();

        // $user = new User();
        // $user->username = request('username');
        // $user->email = request('email');
        // $user->phone = request('phone');
        // $user->password = Hash::make(request('password'));
        // $user->role = 2;
        // $user->address = NULL;
        // $user->credit_balance = NULL;
        // $user->event_id = $id;
        // $user->save();

        return redirect()->route('manageUsers', ['id'=>$id])->with('message', 'Assistant registered successfully');
    }

    public function editUser($id, $user_id){
        $events = Events::findOrFail($id);
        $assistants = Assistant::findOrFail($user_id);

        return view('editUser', ['events' => $events, 'assistants' => $assistants]);
    }

    public function updateAssistant(Request $request, $id, $user_id){
        $this->validate(
            $request,
            [
                'username' => 'required|max:255|unique:users,username,'.$id.'',
                'email' => 'required|email|max:255|unique:users,email,'.$id.'',
                'phone' => 'required|regex:/^(\+6)?01[0-46-9]-[0-9]{7,8}$/|max:14',
            ]);
        
            $assistant = Assistant::find($user_id);
            $assistant->username = request('username');
            $assistant->email = request('email');
            $assistant->phone = request('phone');
            $assistant->save();
    
            $user = User::find($assistant->user_id);
            $user->username = request('username');
            $user->email = request('email');
            $user->phone = request('phone');
            $user->save();

        return redirect()->route('manageUsers', ['id'=>$id])->with('message', 'Assistant details updated successfully');
    }

    public function assistantEvent(){
        $assistants = Assistant::all()->where('id', Auth::id());
        $events = Events::all()->where('id', Auth::id()); 

        return view('assistantEvent',['assistants' => $assistants, 'events' => $events]);
    }

}
