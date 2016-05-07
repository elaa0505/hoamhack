@extends('layouts.default')
@section('content')            

<div class="title">Simulate</div>
<form>
@foreach (['cant_sleep' => 'Cannot sleep', 'bad_night' => 'Bad night', 'pre_wake_up' => "Pre wake up", 'wake_up' => 'Wake up'] as $event => $label)
<p style="font-size:2em; font-weight: bold"><a href="{{ route('simulate.trigger', $event) }}">{{ $label }}</a> </p>
@endforeach

</form>

<script type="text/javascript" src="http://assets.codepen.io/assets/common/stopExecutionOnTimeout-f961f59a28ef4fd551736b43f94620b5.js">
     speechSynthesis.speak(SpeechSynthesisUtterance('Hello World'));
</script>


@endsection