<?php


namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Config;




class SimulateController extends Controller
{

    public function index()
    {
        return \View::make('simulate.index');
    }

    public function trigger($event)
    {
        switch ($event) {
            case 'bad_night':
                return $this->triggerBadNight();
                break;
            
            case 'cant_sleep':
                return $this->triggerCantSleep();
                break;

            default:
                print "Unknown event: $event";
                break;
        }
    }


    public function triggerBadNight()
    {
        Config::advanceClock();
        // Slack::send("Sorry. Bad night's sleep. Looks like I will be late today");
    }

}

