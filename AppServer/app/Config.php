<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    protected $table = "config";
    protected $fillable = ['name', 'value'];

    public static function advanceClock()
    {
        $config = Config::whereName('wakeupat')->first();
        $time = \DateTime::createFromFormat("H:i", $config->value);
        $time->add(new \DateInterval('PT1H'));
        $config->value = $time->format("H:i");
        $config->save();
    }
}
