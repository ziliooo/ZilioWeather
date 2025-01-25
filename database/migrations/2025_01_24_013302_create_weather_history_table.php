<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
namespace App\Models;


return new class extends Migration
{
    public function up()
{
    Schema::create('weather_histories', function (Blueprint $table) {
        $table->id();
        $table->string('city');
        $table->string('zipcode');
        $table->float('temperature');
        $table->string('description');
        $table->timestamps();
    });
}

    
};
