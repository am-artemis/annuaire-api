<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->string('name', 100);
            $table->text('address');
            $table->string('zipcode', 5);
            $table->string('city', 100);
            $table->string('country', 50)->nullable();
            $table->decimal('lat', 10,6);
            $table->decimal('lng', 10,6);
            $table->string('phone', 50)->nullable();
            $table->date('from')->nullable();
            $table->date('to')->nullable();
            $table->enum('type', array('perso', 'family'));
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
        Schema::drop('addresses');
    }
}
