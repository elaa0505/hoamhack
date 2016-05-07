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
        print $event;
    }

}

