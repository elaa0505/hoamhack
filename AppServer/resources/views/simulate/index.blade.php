@extends('layouts.default')
@section('content')            

<div class="title">Simulate</div>
<form>
@foreach (['cant_sleep' => 'Cannot sleep', 'bad_night' => 'Bad night', 'pre_wake_up' => "Pre wake up", 'wake_up' => 'Wake up'] as $event => $label)
<p style="font-size:2em; font-weight: bold"><a href="{{ route('simulate.trigger', $event) }}">{{ $label }}</a> </p>
@endforeach

</form>


    <script>
  window.console = window.console || function(t) {};
</script>


<script type="text/javascript">
if ('speechSynthesis' in window) {
    var msg = new SpeechSynthesisUtterance();
    msg.text = "Wake up, please.";
    msg.volume = 1.0;
    window.speechSynthesis.speak(msg);
} 
</script>


@endsection