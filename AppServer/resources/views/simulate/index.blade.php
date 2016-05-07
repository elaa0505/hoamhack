@extends('layouts.default')
@section('content')            
<div class="title">Simulate</div>
<form>
<a href="{{ route('simulate.trigger', 'bad_night') }}">Bad night</a> 
</form>
@endsection