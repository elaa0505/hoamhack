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

    public function show($variable)
    {
        $config = Config::whereName($variable)->first();
        return \Response::json($config);
    }

    public function storeOrUpdate($variable)
    {
        $config = Config::firstOrNew(['name' => $variable]);
        $config->value = \Input::get('value', '');
        $config->save();
        return \Response::json($config);
    }
}

