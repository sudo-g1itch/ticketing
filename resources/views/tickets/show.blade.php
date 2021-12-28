@extends('layouts.enduser')

@section('content')


Subject:{{$ticket->subject}} <br><br>
Description:{{$ticket->description}} <br><br>   
Assignee:{{$ticket->assignee}} <br><br>  <br>

Comments: <br><br>
@foreach($ticket->comments as $comment)
    {{$comment->comment_body}} <br>
@endforeach

{!! Form::open(['action' => ['App\Http\Controllers\CommentController@store', $ticket->id], 'method' => 'POST' ,'enctype' => 'multipart/form-data']) !!}
    {!! Form::text('comment', '', ['class' => 'input','required']) !!}
    {!! Form::submit('Submit', ['class' => 'btn']) !!}
{!! Form::close()!!}

@endsection
