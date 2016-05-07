@extends('layouts.default')
@section('content')            
                <div class="title">Hoamalarm</div>
                <div>
                    <a href="{{ route('api.config.index') }}">config api</a>
                </div>
                <div>
                    <a href="{{ route('clock.index') }}">Clock</a>
                </div>
                <div>
                    <a href="{{ route('simulate.index') }}">Simulation</a>
                </div>
                <div>
                    <a href="{{ route('slack.index') }}">slack</a>
                </div>
@endsection