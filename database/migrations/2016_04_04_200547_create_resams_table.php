<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resams', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100);
            $table->text('address');
            $table->decimal('lat', 10,6);
            $table->decimal('lng', 10,6);
            $table->integer('campus_id')->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('resams');
    }
}
