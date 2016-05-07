@extends('layouts.default')
@section('content')            
                <div class="title">Slack</div>
                @if (!empty($message))
                <div>
                {{ $message }}
                </div>
                @endif

                <div>
                    <a href="{{ route('slack.send', ['text'=>'I am going to be late']) }}">Send I am late message</a>
<!--                     <form action="{{ route('slack.send') }}" method="POST">
                    <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
                    Text: <input type="text" name="text">
                    <input type="submit" value="send">
                    </form>
 -->            
                </div>
@endsection
