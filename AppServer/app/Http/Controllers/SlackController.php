<?php


namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Slack;


class SlackController extends Controller
{

    public function index()
    {
        return \View::make('slack');
    }

    public function send()
    { 
        $text = \Input::get('text');
        $result = Slack::send($text);
        
        return \View::make('slack')->with('message', 'slack says: '.$result);
    }
}

