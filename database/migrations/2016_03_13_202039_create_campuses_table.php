<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCampusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campuses', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name', 40);
            $table->string('city', 20);
            $table->string('short', 20);
            $table->string('prefix', 2)->nullable();
            $table->text('address');
            $table->string('lat', 10);
            $table->string('lng', 10);
            $table->string('photo', 100);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('campuses');
    }
}
