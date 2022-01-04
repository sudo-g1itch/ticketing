<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct(){
        $this->middleware('auth')->except('indexAll','create');
    }


    public function index()
    {
        $user = auth()->user();
        return view('tickets.index')->with(['tickets' => $user->tickets]);
    }

    public function indexAll()
    {
        $tickets= Ticket::all();
        return view('tickets.indexAll')->with(['tickets' => $tickets]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::all();
        $names = array();
        foreach($users as $key => $user){
            $names[$user->name] = $user->name;
        }
        return view('tickets.create')->with(['names' => $names]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        $assignee = $request->get('assignee');
        if(User::where('name',$assignee)->first()){
            $user = User::where('name',$assignee)->first();
            $ticket = new Ticket;
            $ticket->owner_id = $user->id;
            $ticket->subject = $request->get('subject');
            $ticket->description = $request->get('description');
            $ticket->assignee = $request->get('assignee');
            $ticket->save();  
            $tickets= Ticket::all();
            return view('tickets.indexAll')->with(['tickets' => $tickets]);  
        }
        else{
            return response("Tampered request");
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $ticket = Ticket::where('id',$id)->first();
        return view('tickets.show')->with('ticket',$ticket);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $ticket = Ticket::where('id',$id)->first();
        return view('tickets.showAdmin')->with('ticket',$ticket);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ticket $ticket)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ticket $ticket)
    {
        //
    }
}
