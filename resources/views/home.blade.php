@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center my-5">
        <img class="d-block mx-auto" src="/img/jake_dance.png" style="height:500px;width:250px">
        <div class="col-6" style="margin-top:22%">
           <h4 class="text-center mt-5">
               Sir {{auth()->user()->name}}, you have been accoladed<br>
               You can continue your adventure now!
           </h4>
        </div>
    </div>
    <small class="text-center fixed-bottom my-4">Remember the oath.</small>
</div>
@endsection
