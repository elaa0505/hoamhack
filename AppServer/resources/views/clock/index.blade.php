@extends('layouts.default')

@section('meta')            

<script>
    function startTime() {
        var today = new Date();
        var h = today.getHours();
        var m = today.getMinutes();
        var s = today.getSeconds();
        m = checkTime(m);
        s = checkTime(s);
        document.getElementById('clock').innerHTML =
        h + ":" + m + ":" + s;
        var t = setTimeout(startTime, 500);
    }

    function checkTime(i) {
        if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
        return i;
    }
</script>
@endsection


@section('content')            


<div style="width: 500px; height:300px; border: 1px solid gray;">
    <div id="clock"></div>
    <div class="title" style="color: @if ($alarmState=='1')red @else black @endif; font-weight: bold;">Wake at {{ $wakeUpTime or "Not set "}}</div>
</div>

<div>
    <h2><b>Connected Devices</b></h2>
    <div class="well well-sm"><i class="fa fa-coffee fa-3x" aria-hidden="true"></i> <h4>Coffee Maker: @if ($sleepState=='wakeup') Ready @elseif ($sleepState=='prewakeup') Brewing @else Off @endif</h4></div>
    <div class="well well-sm"><i class="fa fa-fire fa-3x" aria-hidden="true"></i> <h4>Heater: @if ($sleepState=='wakeup') 22 @elseif ($sleepState=='prewakeup') 25 @else 22 @endif</h4></div>
    <div class="well well-sm"><i class="fa fa-lightbulb-o fa-3x" aria-hidden="true"></i> <h4>Lights: @if ($sleepState=='wakeup') On @elseif ($sleepState=='prewakeup') Dim @else Off @endif</h4></div>
</div>

<script type="text/javascript">
    startTime();
</script>


<script type="text/javascript">
(function(){
    var sleepState = "{{ $sleepState }}"
    if (sleepState === "wakeup") {
        if ('speechSynthesis' in window) {
            var msg = new SpeechSynthesisUtterance();
            msg.text = "Good Morning! It is time to wake up.";
            msg.volume = 1.0;
            window.speechSynthesis.speak(msg);
        } 
    }

})()
</script>
@endsection                
