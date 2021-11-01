<?php

namespace App\Http\Controllers;

use App\Models\Events;
use App\Models\Tickets;
use App\Models\User;
use App\Models\Checkout;
use App\Models\PageVisit;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    // public function __construct(){
    //     $this->middleware(['auth']);
    // }

    public function index(){
        $events = Events::all();

        $todayDate = Carbon::now();
        // dd($todayDate);

        foreach($events as $event){
            $result = $todayDate->gt($event->start_date);
            if($result){
                $event->event_status = "Closed";
                $event->save();
            }
        }

        return view('home',['events'=>$events]);
    }

    public function index2(){
        $events = Events::all();
        $todayDate = Carbon::now();

        foreach($events as $event){
            $result = $todayDate->gt($event->start_date);
            if($result){
                $event->event_status = "Closed";
                $event->save();
            }
        }


        return view('homeOngoing',['events'=>$events]);
    }

    public function index3(){
        $events = Events::all();
        $todayDate = Carbon::now();

        foreach($events as $event){
            $result = $todayDate->gt($event->start_date);
            if($result){
                $event->event_status = "Closed";
                $event->save();
            }
        }

        return view('homePast',['events'=>$events]);
    }

    public function createEvent(){
        return view('/createEvent');
    }

    public function eventDetails($id){
        $events = Events::findOrFail($id);

        $events->pageVisits()->create();

        return view('viewEvents', ['events' => $events]);
    }

    public function homepageSearch(Request $request)
    {
        $events = Events::where('title', 'LIKE', '%' . addcslashes($request->homeSearch, '%_') . '%')
            ->orWhere('username', 'LIKE', '%' . addcslashes($request->homeSearch, '%_') . '%')
            ->orWhere('tags', 'LIKE', '%' . addcslashes($request->homeSearch, '%_') . '%')
            ->orWhere('type', 'LIKE', '%' . addcslashes($request->homeSearch, '%_') . '%')
            ->orWhere('event_status', 'LIKE', '%' . addcslashes($request->homeSearch, '%_') . '%')
            ->orWhere('start_date', 'LIKE', '%' . addcslashes($request->homeSearch, '%_') . '%')
            ->orWhere('start_time', 'LIKE', '%' . addcslashes($request->homeSearch, '%_') . '%')
            ->get();

        if ($events->isEmpty()) {
            return view('noResult');
        } else {
            return view('homeEvents1', ['events' => $events]);
        }
    }

    public function homepageSearch2(Request $request)
    {
        $events = Events::where('title', 'LIKE', '%' . addcslashes($request->homeSearch, '%_') . '%')
            ->orWhere('username', 'LIKE', '%' . addcslashes($request->homeSearch, '%_') . '%')
            ->orWhere('tags', 'LIKE', '%' . addcslashes($request->homeSearch, '%_') . '%')
            ->orWhere('type', 'LIKE', '%' . addcslashes($request->homeSearch, '%_') . '%')
            ->orWhere('event_status', 'LIKE', '%' . addcslashes($request->homeSearch, '%_') . '%')
            ->orWhere('start_date', 'LIKE', '%' . addcslashes($request->homeSearch, '%_') . '%')
            ->orWhere('start_time', 'LIKE', '%' . addcslashes($request->homeSearch, '%_') . '%')
            ->get();

        if ($events->isEmpty()) {
            return view('noResult');
        } else {
            return view('homeEvents2', ['events' => $events]);
        }
    }

    public function homepageSearch3(Request $request)
    {
        $events = Events::where('title', 'LIKE', '%' . addcslashes($request->homeSearch, '%_') . '%')
            ->orWhere('username', 'LIKE', '%' . addcslashes($request->homeSearch, '%_') . '%')
            ->orWhere('tags', 'LIKE', '%' . addcslashes($request->homeSearch, '%_') . '%')
            ->orWhere('type', 'LIKE', '%' . addcslashes($request->homeSearch, '%_') . '%')
            ->orWhere('event_status', 'LIKE', '%' . addcslashes($request->homeSearch, '%_') . '%')
            ->orWhere('start_date', 'LIKE', '%' . addcslashes($request->homeSearch, '%_') . '%')
            ->orWhere('start_time', 'LIKE', '%' . addcslashes($request->homeSearch, '%_') . '%')
            ->get();

        if ($events->isEmpty()) {
            return view('noResult');
        } else {
            return view('homeEvents3', ['events' => $events]);
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
        $event->remaining_num_of_participant = $event->num_of_participant;
        $event->registration_start_date = request('registration_start_date');
        $event->registration_end_date = request('registration_end_date'); 
        $event->save();

        $events = Events::all();
        return redirect()->route('eventDetails', ['id'=>$id])->with("message", "Details updated successfully");
    }

    public function publishEventPage($id){
        $events = Events::findOrFail($id);
        $tickets = Tickets::all()->where('event_id', $id);
        $ticketCount = 0;
        foreach($tickets as $ticket){
            if($ticket != null){
                $ticketCount += $ticket->quantity;
            }
        }

        return view('publishEvent', ['events' => $events, 'tickets' => $tickets, 'ticketCount' => $ticketCount]);
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
        $event = Events::findOrFail($id);

        // convert created_at and end date to carbon
        $startDate = $event->created_at;
        $endDate = new Carbon($event->end_date . " " . $event->end_time);

        // group checkouts into year|weekOfYear and ticket type
        $xLabel = [];
        $ticketsLabel = $event->tickets->pluck("type");
        $copyStartDate = $startDate->copy();
        while ($copyStartDate <= $endDate) {
            $startDateOfWeek = $copyStartDate->copy()->startOfWeek();
            $endDateOfWeek = $copyStartDate->copy()->endOfWeek();
            $xLabelString = $startDateOfWeek->format("Y-m-d") . " - " . $endDateOfWeek->format("Y-m-d");
            if(!in_array($xLabelString, $xLabel)) {
                array_push($xLabel, $xLabelString);
            }
            $copyStartDate->addDays(7);
        }
        $startDateOfWeek = $endDate->copy()->startOfWeek();
        $endDateOfWeek = $endDate->copy()->endOfWeek();
        $xLabelString = $startDateOfWeek->format("Y-m-d") . " - " . $endDateOfWeek->format("Y-m-d");
        if(!in_array($xLabelString, $xLabel)) {
            array_push($xLabel, $xLabelString);
        }

        $checkoutGroups = $event->checkouts->filter(function ($checkout) use ($startDate, $endDate) {
            return $checkout->created_at >= $startDate && $checkout->created_at <= $endDate;
        })->groupBy([
            function ($checkout) {
                return $checkout->ticket->type;
            },
            function ($checkout) {
                return $checkout->created_at->year . "|" . $checkout->created_at->weekOfYear;
            } 
        ]);
        foreach ($checkoutGroups as $ticketName => $values) {
            foreach($values as $key2 => $value) {
                $arr = explode("|", $key2);
                $year = $arr[0];
                $weekOfYear = $arr[1];
                $date = (new Carbon())->setISODate($year, $weekOfYear);
                $startDateOfWeek = $date->copy()->startOfWeek();
                $endDateOfWeek = $date->copy()->endOfWeek();
                $labelString = $startDateOfWeek->format("Y-m-d") . " - " . $endDateOfWeek->format("Y-m-d");
                $checkoutGroups[$ticketName][$labelString] = $value;
                unset($checkoutGroups[$ticketName][$key2]);
            }
        }

        $totalRevenues = [];
        foreach ($ticketsLabel as $ticket) {
            if (!$checkoutGroups->has($ticket)) {
                $totalRevenues[$ticket] = array_fill(0, count($xLabel), 0);
            }
            else {
                $temp = [];
                for ($i = 0; $i < count($xLabel); $i++) {
                    $label = $xLabel[$i];
                    $value = 0;
                    if ($checkoutGroups[$ticket]->has($label)) {
                        $value = $checkoutGroups[$ticket][$label]->sum(function ($checkout) {
                            return $checkout->total_price;
                        });
                    }
                    array_push($temp, $value);
                }
                $totalRevenues[$ticket] = $temp;
            }
        }

        $totalRevenue = 0;
        foreach ($totalRevenues as $priceArr) {
            $totalRevenue += array_sum($priceArr);
        }
        
        $totalTickets = [];
        foreach ($ticketsLabel as $ticket) {
            if (!$checkoutGroups->has($ticket)) {
                $totalTickets[$ticket] = array_fill(0, count($xLabel), 0);
            }
            else {
                $temp = [];
                for ($i = 0; $i < count($xLabel); $i++) {
                    $label = $xLabel[$i];
                    $value = 0;
                    if ($checkoutGroups[$ticket]->has($label)) {
                        $value = $checkoutGroups[$ticket][$label]->sum(function ($checkout) {
                            return $checkout->quantity;
                        });
                    }
                    array_push($temp, $value);
                }
                $totalTickets[$ticket] = $temp;
            }
        }

        $totalTicket = 0;
        foreach ($totalTickets as $priceArr) {
            $totalTicket += array_sum($priceArr);
        }

        // sum all the tickets available
        $ticketsAvailable = $event->tickets->sum(function ($ticket) {
            return $ticket->quantity;
        });

        // group the page visited by year|weeksOfYear
        $pageVisitedGroup = $event->pageVisits->filter(function ($pageVisit) use ($startDate, $endDate) {
            return $pageVisit->created_at >= $startDate && $pageVisit->created_at <= $endDate;
        })->groupBy(
            function ($checkout) {
                return $checkout->created_at->year . "|" . $checkout->created_at->weekOfYear;
            }
        );
        foreach ($pageVisitedGroup as $key => $value) {
            $arr = explode("|", $key);
            $year = $arr[0];
            $weekOfYear = $arr[1];
            $date = (new Carbon())->setISODate($year, $weekOfYear);
            $startDateOfWeek = $date->copy()->startOfWeek();
            $endDateOfWeek = $date->copy()->endOfWeek();
            $pageVisitedGroup[$startDateOfWeek->format("Y-m-d") . " - " . $endDateOfWeek->format("Y-m-d")] = $value;
            unset($pageVisitedGroup[$key]);
        }
        $pageVisited = [];
        for ($i = 0; $i < count($xLabel); $i++) {
            $label = $xLabel[$i];
            $value = 0;
            if ($pageVisitedGroup->has($label)) {
                $value = $pageVisitedGroup[$label]->count();
            }
            array_push($pageVisited, $value);
        }
        
        $totalVisited = array_sum($pageVisited);
        return view('dashboard', [
            'event' => $event,
            "xLabel" => $xLabel,
            "ticketsLabel" => $ticketsLabel,
            "totalRevenues" => $totalRevenues,
            "totalRevenue" => $totalRevenue,
            "totalTickets" => $totalTickets,
            "totalTicket" => $totalTicket,
            "ticketsAvailable" => $ticketsAvailable,
            "pageVisited" => $pageVisited,
            "totalVisited" => $totalVisited,
        ]);
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
        
        $tickets = [];
        for ($i=0; $i < count($request->quantity); $i++) {
            if($request->quantity[$i] != null){
                $ticket = Tickets::find($request->ticketID[$i]);
                $tickets[] = collect([
                    "ticket" => $ticket,
                    "quantity" => $request->quantity[$i],
                ]);
            } 
        }
        $tickets = collect($tickets);

        return redirect()->route('checkoutConfirm', ['id'=>$id])->with("tickets", $tickets);
    }

    public function checkoutConfirmPage($id){
        $events = Events::findOrFail($id);

        return view('checkoutConfirm', ['events' => $events]);
    }

    public function confirmFinalCheckout(Request $request, $id){
        $events = Events::findOrFail($id);

        switch($request->input('action')){
            case 'cancel':
                return redirect()->route('home');

            break;

            case 'confirm': 
                $user = Auth::user();
                $totalPrice = 0;
                $checkouts = array();
                for ($i=0; $i < count($request->quantity); $i++) {
                    if($request->quantity[$i] != null){
                        $ticket = Tickets::find($request->ticketID[$i]);
                        $ticket->quantity_left = $ticket->quantity_left - $request->quantity[$i];
                        $events->remaining_num_of_participant = $events->remaining_num_of_participant - $request->quantity[$i];

                        $checkouts[] = [
                            "ticket_id" => $ticket->id,
                            "quantity" => $request->quantity[$i],
                            "total_price" => $ticket->price * $request->quantity[$i],
                            "validity" => 1,
                            "status" => 1,
                        ];
                    }
                    $totalPrice += $ticket->price * $request->quantity[$i];
                }
                if ($user->credit_balance < $totalPrice) {
                    $this->validate(
                        $request,[
                            'amount' => 'numeric|min:1|max:1500',
                            'ccn' => 'max:19', 
                    ]);
                }
                
                $user->checkouts()->createMany($checkouts);
    
                $user->credit_balance += ($request->amount ?? 0) - $totalPrice;
                $user->save();
                $ticket->save();
                $events->save();
                return redirect()->route('myTickets');

            break;
        }
    }
}