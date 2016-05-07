<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConfigTable extends Migration
{
    public function up()
    {
         Schema::create('config', function($table)
        {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('value');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('config');
    }
}
