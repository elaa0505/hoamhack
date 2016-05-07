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
                $this->triggerBadNight();
                break;
            
            case 'cant_sleep':
                $this->triggerCannotSleep();
                break;

            default:
                print "Unknown event: $event";
                break;
        }

        return $this->index();
    }


    public function triggerBadNight()
    {
        Config::advanceClock();
        // system('say "wake up"');
        // Slack::send("Sorry. Bad night's sleep. Looks like I will be late today");

    }


    public function triggerCannotSleep()
    {
        system('say "Can you not sleep? Shall I play you a lullaby?"');        
    }

}

