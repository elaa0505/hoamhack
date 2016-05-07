<?php


namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Config;




class ClockController extends Controller
{

    public function index()
    {
        $wakeUpTime = Config::whereName('wakeupat')->first();
        $alarmState = Config::whereName('alarm')->first();

        return \View::make('clock.index')
            ->with('wakeUpTime', $wakeUpTime->value)
            ->with('alarmState', $alarmState->value);
    }

}

