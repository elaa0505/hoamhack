<?php


namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Config;
use App\Slack;
use App\Lights;




class SimulateController extends Controller
{

    public function index()
    {
        return \View::make('simulate.index');
    }

    public function trigger($event)
    {
        switch ($event) {
            case 'reset':
                $this->triggerReset();
                break;

            case 'bad_night':
                $this->triggerBadNight();
                break;
            
            case 'cant_sleep':
                $this->triggerCannotSleep();
                break;

            case 'wake_up':
                $this->triggerWakeUp();
                break;

            case 'pre_wake_up':
                $this->triggerPreWakeUp();
                break;

            default:
                print "Unknown event: $event";
                break;
        }

        return \Redirect::route('simulate.index');
    }

    public function triggerReset()
    {
        Config::whereName('sleepstate')->update(['value'=>'sleep']);
        Config::whereName('alarm')->update(['value'=>0]);
        Config::whereName('wakeupat')->update(['value'=>"6:00"]);
        Lights::off();
    }

    public function triggerBadNight()
    {
        Config::advanceClock();
        system('say "wake up"');
        Slack::send("Sorry. Bad night's sleep. Looks like I will be late today");
    }


    public function triggerCannotSleep()
    {
        system('say "Can you not sleep? Shall I play you a lullaby?"');        
    }


    public function triggerWakeUp()
    {
        Config::whereName('sleepstate')->update(['value'=>'wakeup']);
        Lights::on();
        // system('say "Please wake up."');        
    }


    public function triggerPreWakeUp()
    {
        Config::whereName('sleepstate')->update(['value'=>'prewakeup']);
        Lights::dimmed();
        system('say "I am going to turn on the heat now."');        
    }

}

