<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGadzTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gadz', function (Blueprint $table) {
            $table->increments('id');
            $table->string('user_id', 6);
            $table->string('buque', 100);
            $table->string('fams', 100);
            $table->text('famsSearch');
            $table->integer('proms');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('gadz');
    }
}
