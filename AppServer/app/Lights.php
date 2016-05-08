<?php

namespace App;


class Lights
{
    public static function send($state, $brightness = null)
    {
        $data = ['on' => $state, 'sat'=>254, 'hue'=>30000];
        if ($brightness)
        {
            $data["bri"] = $brightness;
        }
        
        $ch = curl_init("http://192.168.2.2/api/929-B8kKZaWviahyppQ3dKdFm2GYG51YiBd6ZsI0/lights/2/state");
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);
        
        return $result;
    }

    public static function off()
    {
        return Lights::send(false);
    }

    public static function dimmed()
    {
        return Lights::send(true, 100);
    }

    public static function on()
    {
        return Lights::send(true, 254);
    }

}
