@extends('layouts.default')

@section('meta')            
<meta http-equiv="refresh" content="100" >
@endsection

@section('content')            
<div class="title">Wake up time is {{ $wakeUpTime or "Not set "}}</div>
@endsection                
