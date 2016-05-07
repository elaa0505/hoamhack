@extends('layouts.default')

@section('meta')            
<meta http-equiv="refresh" content="100" >
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

<div style="width: 500px; height:600px; border: 1px solid gray;">
    <div id="clock"></div>
    <div class="title" style="color: @if ($alarmState=='1')red @else black @endif; font-weight: bold;">Wake at {{ $wakeUpTime or "Not set "}}</div>
</div>

<script type="text/javascript">
    startTime();
</script>
@endsection                
