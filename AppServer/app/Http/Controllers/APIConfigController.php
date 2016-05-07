<?php


namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Config;

class APIConfigController extends Controller
{

    public function index()
    {
        $items = Config::get();
        return \Response::json($items->toArray());
    }
}

