<?php

namespace App\Http\Controllers;

use App\Models\Events;
use App\Models\Tickets;
use App\Models\User;
use App\Models\Checkout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    // public function __construct(){
    //     $this->middleware(['auth']);
    // }

    public function index(){
        $events = Events::all();

        return view('home',['events'=>$events]);
    }

    public function createEvent(){
        return view('/createEvent');
    }

    public function eventDetails($id){
        $events = Events::findOrFail($id);

        return view('viewEvents', ['events' => $events]);
    }

    public function homepageSearch(Request $request)
    {
        $events = Events::where('title', 'LIKE', '%' . addcslashes($request->homeSearch, '%_') . '%')
            ->orWhere('username', 'LIKE', '%' . addcslashes($request->homeSearch, '%_') . '%')
            ->orWhere('tags', 'LIKE', '%' . addcslashes($request->homeSearch, '%_') . '%')
            ->get();
        if ($events->isEmpty()) {
            return view('noResult');
        } else {
            return view('homeEvents', ['events' => $events]);
        }
    }

    public function create(Request $request){
        $this->validate(
            $request,
            [
                'title' => 'required|max:255',
                'description' => 'required|max:65535',
                'category' => 'required',
                'tags' => 'max:50',
                'type' => 'required',
                'venue_name' => 'required|max:255',
                'venue_address' => 'max:255',
                'start_date' => 'required',
                'end_date' => 'required',
                'start_time' => 'required',
                'end_time' => 'required',
                'cover_image' => 'required|file'
            ]
        );

        $userID = Auth::user()->id;
        $user = User::find(Auth::id()); 

        $events = new Events();
        $events->created_by = $userID;
        $events->username = $user->username;
        $events->title = request('title');
        $events->description = request('description');
        $events->category = request('category');
        if(request('tags')){
            $events->tags = request('tags');
        }
        else{
            $events->tags = "No tags";
        }
        $events->type = request('type');
        $events->venue_name = request('venue_name');
        if(request('venue_address')){
            $events->venue_address = request('venue_address');
        }
        else{
            $events->venue_address = "";
        }
        $events->start_date = request('start_date');
        $events->end_date = request('end_date');
        $events->start_time = request('start_time');
        $events->end_time = request('end_time');
        $events->publish_status = "Not published";
        $events->event_status = "Pending";
        $events->cover_image = file_get_contents(request('cover_image'));
        $events->save();

        $data = User::findOrFail($userID);
        $data->role = 0;
        $data->save();

        return redirect('/manageEvents');
        
    }

    public function manageEvent(){
        return view('manageEvents');
    }

    public function showDetails($id){
        $events = Events::findOrFail($id);

        return view('eventDetails', ['events' => $events]);
        
    }

    public function updateDetails(Request $request, $id){
        $this->validate(
            $request,
            [
                'title' => 'required|max:255',
                'description' => 'required|max:65535',
                'tags' => 'max:50',
                'venue_name' => 'required|max:255',
                'venue_address' => 'max:255',
                'start_date' => 'required',
                'end_date' => 'required',
                'start_time' => 'required',
                'end_time' => 'required',
                'cover_image' => 'file',
                'num_of_participant'=> 'required|numeric|min:10|max:1000',
                'registration_start_date' => 'required',
                'registration_end_date' => 'required'
            ]
        );

        $user = User::find(Auth::id()); 

        $event = Events::find($id);
        $event->title = request('title');
        $event->username = $user->username;
        $event->description = request('description');
        if(request('tags')){
            $event->tags = request('tags');
        }
        $event->venue_name = request('venue_name');
        if(request('venue_address')){
            $event->venue_address = request('venue_address');
        }
        $event->start_date = request('start_date');
        $event->end_date = request('end_date');
        $event->start_time = request('start_time');
        $event->end_time = request('end_time');
        if (request('cover_image')){
            $event->cover_image = file_get_contents(request('cover_image'));  
        }
        $event->num_of_participant = request('num_of_participant');
        $event->registration_start_date = request('registration_start_date');
        $event->registration_end_date = request('registration_end_date'); 
        $event->save();

        $events = Events::all();
        return redirect()->route('eventDetails', ['id'=>$id])->with("message", "Details updated successfully");
    }

    public function publishEventPage($id){
        $events = Events::findOrFail($id);
        return view('publishEvent', ['events' => $events]);
    }

    public function publishEventAction($id){
        $event = Events::find($id);     
        $event->publish_status = "Published";
        $event->event_status = "Open";
        $event->save();

        $events = Events::all();
        return redirect("/manageEvents");
    }

    public function openDashboard($id){
        $events = Events::findOrFail($id);

        return view('dashboard', ['events' => $events]);
    }

    public function deleteEvent($id){
        $events = Events::findOrFail($id);
        $events->delete();

        $events = Events::all();
        return redirect('/manageEvents');
    }

    public function showCheckout($id){
        $events = Events::findOrFail($id);

        return view('checkout', ['events' => $events]);
    }

    public function checkoutRegister(Request $request, $id){
        $events = Events::findOrFail($id);
        
        // $this->validate(
        //     $request,
        //     [
        //         "quantity" => "array",
        //         "quantity.*" => "required|integer",
        //     ]
        // );
        $tickets = [];
        for ($i=0; $i < count($request->quantity); $i++) {
            if($request->quantity[$i] != null){
                $tickets[] = [
                    "ticket_id" => $request->ticketID[$i],
                    "quantity" => $request->quantity[$i],
                    "total_price" => $request->price[$i] * $request->quantity[$i],
                    "paid_status" => "Unpaid",
                ];
            } 
        }
        // foreach($request->checkouts as $checkout){
        //     $tickets[] =[
        //         "ticket_id" => $id,
        //         "quantity" => $checkout->quantity
        //     ]; 
        // }

        Auth::user()->checkouts()->createMany($tickets);

        return view('checkoutConfirm',['events'=>$events]);
    }


}