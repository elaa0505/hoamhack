<?php


namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Config;


function slack($message)
{
    $data = "payload=" . json_encode(array(
                "text"          =>  $message,
                "username" => "The Sleepy One",
                "icon_emoji" => ":ghost:"
        ));

    $ch = curl_init("https://hooks.slack.com/services/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");
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    curl_close($ch);
    
    return $result;
}


class SlackController extends Controller
{

    public function index()
    {
        return \View::make('slack');
    }

    public function send()
    { 
        $text = \Input::get('text');
        $result = slack($text);
        
        return \View::make('slack')->with('message', 'slack says: '.$result);
    }
}

