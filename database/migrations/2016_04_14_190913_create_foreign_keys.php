<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateForeignKeys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function(Blueprint $table) {
            $table->foreign('campus_id')->references('id')->on('campuses')
                        ->onDelete('restrict')
                        ->onUpdate('restrict'); // Hum cascade ?
        });

        Schema::table('gadz', function(Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')
                        ->onDelete('cascade')
                        ->onUpdate('restrict'); // cascade ?
        });

        Schema::table('photos', function(Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')
                        ->onDelete('cascade')
                        ->onUpdate('restrict'); // cascade ?
        });

        Schema::table('addresses', function(Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')
                        ->onDelete('cascade')
                        ->onUpdate('restrict'); // idem
        });

        Schema::table('resams', function(Blueprint $table) {
            $table->foreign('campus_id')->references('id')->on('campuses')
                        ->onDelete('restrict')
                        ->onUpdate('restrict');
        });
        
        Schema::table('cursus', function(Blueprint $table) {
            $table->foreign('campus_id')->references('id')->on('campuses')
                        ->onDelete('restrict')
                        ->onUpdate('restrict'); // idem
        });
        Schema::table('user_cursus', function(Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')
                        ->onDelete('cascade')
                        ->onUpdate('restrict');
        });
        Schema::table('user_cursus', function(Blueprint $table) {
            $table->foreign('cursus_id')->references('id')->on('cursus')
                        ->onDelete('restrict')
                        ->onUpdate('restrict');
        });

        Schema::table('jobs', function(Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')
                        ->onDelete('cascade')
                        ->onUpdate('restrict');
        });
        
        Schema::table('user_degree', function(Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')
                        ->onDelete('cascade')
                        ->onUpdate('restrict');
        });
        Schema::table('user_degree', function(Blueprint $table) {
            $table->foreign('degree_id')->references('id')->on('degrees')
                        ->onDelete('restrict')
                        ->onUpdate('restrict');
        });

        Schema::table('bouls', function(Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')
                        ->onDelete('cascade')
                        ->onUpdate('restrict');
        });
        Schema::table('bouls', function(Blueprint $table) {
            $table->foreign('campus_id')->references('id')->on('campuses')
                        ->onDelete('restrict')
                        ->onUpdate('restrict');
        });

        Schema::table('user_social', function(Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')
                        ->onDelete('cascade')
                        ->onUpdate('restrict');
        });
        Schema::table('user_social', function(Blueprint $table) {
            $table->foreign('social_id')->references('id')->on('socials')
                        ->onDelete('restrict')
                        ->onUpdate('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function(Blueprint $table) {
            $table->dropForeign('users_campus_id_foreign');
        });

        Schema::table('gadz', function(Blueprint $table) {
            $table->dropForeign('gadz_user_id_foreign');
        });

        Schema::table('photos', function(Blueprint $table) {
            $table->dropForeign('photos_user_id_foreign');
        });

        Schema::table('addresses', function(Blueprint $table) {
            $table->dropForeign('addresses_user_id_foreign');
        });
   
        Schema::table('resams', function(Blueprint $table) {
            $table->dropForeign('resams_campus_id_foreign');
        });

        Schema::table('cursus', function(Blueprint $table) {
            $table->dropForeign('cursus_campus_id_foreign');
        });

        Schema::table('user_cursus', function(Blueprint $table) {
            $table->dropForeign('user_cursus_user_id_foreign');
        });
        Schema::table('user_cursus', function(Blueprint $table) {
            $table->dropForeign('user_cursus_cursus_id_foreign');
        });

        Schema::table('user_degree', function(Blueprint $table) {
            $table->dropForeign('user_degree_user_id_foreign');
        });
        Schema::table('user_degree', function(Blueprint $table) {
            $table->dropForeign('user_degree_degree_id_foreign');
        });
        
        Schema::table('bouls', function(Blueprint $table) {
            $table->dropForeign('bouls_user_id_foreign');
        });
        Schema::table('bouls', function(Blueprint $table) {
            $table->dropForeign('bouls_campus_id_foreign');
        });

        Schema::table('jobs', function(Blueprint $table) {
            $table->dropForeign('jobs_user_id_foreign');
        });

        Schema::table('user_social', function(Blueprint $table) {
            $table->dropForeign('user_social_user_id_foreign');
        });
        Schema::table('user_social', function(Blueprint $table) {
            $table->dropForeign('user_social_social_id_foreign');
        });
    }
}
