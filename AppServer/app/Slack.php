<?php

namespace App;


class Slack
{
    public static function send($message)
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
}
