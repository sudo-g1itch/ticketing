@extends('layouts.main')

@section('content')

<table class="table">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Subject</th>
        <th scope="col">Description</th>
        <th scope="col">Action</th>
      </tr>
    </thead>
    <tbody>
        @foreach($tickets as $ticket)
            <tr>
                <th scope="row">{{$ticket->id}}</th>
                <td>{{$ticket->subject}}</td>
                <td>{{$ticket->description}}</td>
                <td><a href="/edit/{{$ticket->id}}">View</a></td></td>
            </tr>
        @endforeach
    </tbody>
  </table>

@endsection

