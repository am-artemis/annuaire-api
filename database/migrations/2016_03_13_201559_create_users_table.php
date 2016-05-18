<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->string('id', 6);
            $table->primary('id');

            $table->string('firstname', 100);
            $table->string('lastname', 100);
            $table->date('birthday');
            $table->integer('year');
            $table->integer('campus_id')->unsigned();
            $table->enum('gender', ['m', 'f'])->nullable();
            $table->string('email', 100)->unique();
            $table->string('phone', 50);
            $table->text('tags')->nullable();
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
        Schema::drop('users');
    }
}
