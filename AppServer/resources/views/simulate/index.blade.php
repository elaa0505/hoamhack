@extends('layouts.default')
@section('content')            

<div class="title">Simulate</div>
<form>

@foreach (['reset' => 'Reset', 'bad_night' => 'Bad night', 'pre_wake_up' => "Pre wake up", 'wake_up' => 'Wake up'] as $event => $label)
<p style="font-size:2em; font-weight: bold"><a href="{{ route('simulate.trigger', $event) }}">{{ $label }}</a> </p>
@endforeach

</form>


<script>
  // not sure what this does
  window.console = window.console || function(t) {};
</script>


@endsection