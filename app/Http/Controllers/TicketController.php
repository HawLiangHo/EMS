<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Events;
use App\Models\Assistant;
use App\Models\Tickets;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    public function manageTickets($id){
        $events = Events::findOrFail($id);
        $tickets = Tickets::all()->where('event_id', $id);

        return view('manageTickets', ['tickets' => $tickets, 'events' => $events]);
    }

    public function addTicketsPage($id){
        $events = Events::findOrFail($id);

        return view('addTickets', ['events' => $events]);
    }

    public function saveTicket(Request $request, $id){
        $this->validate(
            $request,
            [
                'name' => 'required|max:255',
                'type' => 'required',
                'quantity' => 'required|numeric|min:1|max:1000',
                'price' => 'required|numeric|min:0|max:1000',
                'link' => 'required|max:255'
            ]);
        
        $ticket = new Tickets();
        $ticket->event_id = $id;
        $ticket->name = request('name');
        $ticket->type = request('type');
        $ticket->quantity = request('quantity');
        $ticket->quantity_left = request('quantity');
        $ticket->price = request('price');
        $ticket->link = request('link');
        $ticket->save();

        return redirect()->route('manageTickets', ['id'=>$id])->with('message', 'Ticket saved successfully');
    }

    public function editTicket($id, $ticket_id){
        $events = Events::findOrFail($id);
        $tickets = Tickets::findOrFail($ticket_id);

        return view('editTicket', ['events' => $events, 'tickets' => $tickets]);
    }

    public function updateTicket(Request $request, $id, $ticket_id){
        $this->validate(
            $request,
            [
                'name' => 'required|max:255',
                'type' => 'required',
                'quantity' => 'required|numeric|min:1|max:1000',
                'price' => 'required|numeric|min:0|max:1000',
            ]);
        
        $ticket = Tickets::find($ticket_id);
        $ticket->name = request('name');
        $ticket->type = request('type');
        $ticket->quantity = request('quantity');
        $ticket->quantity_left = request('quantity');
        $ticket->price = request('price');
        $ticket->save();

        return redirect()->route('manageTickets', ['id'=>$id])->with('message', 'Ticket updated successfully');
    }
}
