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
            $table->string('user_id', 6);
            $table->primary('user_id');

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
