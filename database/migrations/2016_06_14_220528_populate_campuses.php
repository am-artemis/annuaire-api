<?php

use Illuminate\Database\Migrations\Migration;

class PopulateCampuses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('campuses')->insert([
            ['name' => 'Tabagn\'s de Clun\'s', 'city' => 'Cluny', 'short' => 'Clun\'s', 'prefix' => 'cl', 'tbk' => 1, 'address' => 'Rue porte de Paris, 71250 Cluny', 'lat' => '46.2157467', 'lng' => '2.2088258', 'photo' => 'cluns.jpg'],
            ['name' => 'Tabagn\'s de Birse', 'city' => 'Lille', 'short' => 'Birse', 'prefix' => 'li', 'tbk' => 1, 'address' => '8 Boulevard Louis XIV, 59800 Lille', 'lat' => '50.6280252', 'lng' => '3.0711672', 'photo' => 'birse.jpg'],
            ['name' => 'KIN d\'Aix', 'city' => 'Aix-en-Provence', 'short' => 'KIN', 'prefix' => 'kin', 'tbk' => 1, 'address' => '2 Cours des Arts et Métiers, 13617 Aix en Provence', 'lat' => '43.4783791', 'lng' => '5.4211451', 'photo' => 'kin.jpg'],
            ['name' => 'Jardin de Kanak', 'city' => 'Karlsruhe', 'short' => 'Kanak', 'prefix' => 'ka', 'tbk' => 1, 'address' => 'Karlsruhe Institute of Technology, Karlsruhe, Allemagne', 'lat' => '49.0119199', 'lng' => '8.4170303', 'photo' => 'kanak.jpg'],
            ['name' => 'Boquette d\'Angers', 'city' => 'Angers', 'short' => 'Boquette', 'prefix' => 'an', 'tbk' => 1, 'address' => '2 Boulevard du Ronceray, 49100 Angers', 'lat' => '47.4751627', 'lng' => '-0.5593541', 'photo' => 'boquette.jpg'],
            ['name' => 'Tabagn\'s de Siber\'s', 'city' => 'Metz', 'short' => 'Siber\'s', 'prefix' => 'me', 'tbk' => 1, 'address' => '4 Rue Augustin Fresnel, 57070 Metz', 'lat' => '49.094651', 'lng' => '6.226145', 'photo' => 'sibers.jpg'],
            ['name' => 'Institut de Chambéry', 'city' => 'Chambéry', 'short' => 'Chambéry', 'prefix' => null, 'tbk' => 0, 'address' => 'Savoie Technolac, 73370 Le Bourget-du-Lac', 'lat' => '45.6431518', 'lng' => '5.870204', 'photo' => 'chambery.jpg'],
            ['name' => 'Insitut de Bastia', 'city' => 'Bastia', 'short' => 'Bastia', 'prefix' => null, 'tbk' => 0, 'address' => '2 Avenue Emile Sari, 20200 Bastia', 'lat' => '42.7036804', 'lng' => '9.4520107', 'photo' => 'bastia.jpg'],
            ['name' => 'Institut de Chalon-sur-Saône', 'city' => 'Chalon-sur-Saône', 'short' => 'Chalon-sur-Saône', 'prefix' => null, 'tbk' => 0, 'address' => '2 Rue Thomas Dumorey 71100 Chalon-sur-Saône', 'lat' => '46.775802', 'lng' => '4.857652', 'photo' => 'chalon.jpg'],
            ['name' => 'Campus de P3', 'city' => 'Paris', 'short' => 'P3', 'prefix' => 'pa', 'tbk' => 0, 'address' => '151 Boulevard de l\'Hôpital, 75013 Paris', 'lat' => '48.8336064', 'lng' => '2.3583875', 'photo' => 'paris.jpg'],
            ['name' => 'Tabagn\'s de Châlon\'s', 'city' => 'Châlons-en-Champagne', 'short' => 'Châlon\'s', 'prefix' => 'ch', 'tbk' => 1, 'address' => 'Rue Saint-Dominique, 51000 Châlons-en-Champagne', 'lat' => '48.8952055', 'lng' => '3.3583826', 'photo' => 'chalons.jpg'],
            ['name' => 'Tabagn\'s de Bordel\'s', 'city' => 'Bordeaux', 'short' => 'Bordel\'s', 'prefix' => 'bo', 'tbk' => 1, 'address' => 'Esplanade des Arts et Métiers, 33400 Talence', 'lat' => '44.8204421', 'lng' => '-0.5869131', 'photo' => 'bordels.jpg'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('campuses')->truncate();
    }
}
