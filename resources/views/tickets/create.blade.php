@extends('layouts.enduser')

@section('content')

{!! Form::open(['action' => 'App\Http\Controllers\TicketController@store', 'method' => 'POST' ,'enctype' => 'multipart/form-data']) !!}
    <div class="form-group">
        <label>Subject</label>
        {!! Form::text('subject', '', ['class' => 'form-control','required']) !!}
    </div>
    <div class="form-group">
        <label>Description</label>
        {!! Form::textarea('description', '', ['class' => 'form-control']) !!}
    </div>
    <div class="form-group">
        <label>Assignee</label>
        {!! Form::select('assignee', $names,['class' => 'form-control']) !!}
    </div>
    
    {!! Form::submit('Submit', ['class' => 'btn']) !!}
{!! Form::close()!!}

@endsection

