<?php

use Illuminate\Database\Seeder;

class CampusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('campuses')->insert([
            ['name' => 'Tabagn\'s de Clun\'s', 'city' => 'Cluny', 'short' => 'Clun\'s', 'prefix' => 'cl', 'address' => 'Rue porte de Paris, 71250 Cluny', 'lat' => 46.2157467, 'lng' => 2.2088258, 'photo' => 'campus/cluns.jpg'],
            ['name' => 'Tabagn\'s de Birse', 'city' => 'Lille', 'short' => 'Birse', 'prefix' => 'li', 'address' => '8 Boulevard Louis XIV, 59800 Lille', 'lat' => 50.6280252, 'lng' => 3.0711672, 'photo' => 'campus/birse.jpg'],
            ['name' => 'KIN d\'Aix', 'city' => 'Aix-en-Provence', 'short' => 'KIN', 'prefix' => 'ai', 'address' => '2 Cours des Arts et Métiers, 13617 Aix en Provence', 'lat' => 43.4783791, 'lng' => 5.4211451, 'photo' => 'campus/kin.jpg'],
            ['name' => 'Jardin de Kanak', 'city' => 'Karlsruhe', 'short' => 'Kanak', 'prefix' => 'ka', 'address' => 'Karlsruhe Institute of Technology, Karlsruhe, Allemagne', 'lat' => 49.0119199, 'lng' => 8.4170303, 'photo' => 'campus/kanak.jpg'],
            ['name' => 'Boquette d\'Angers', 'city' => 'Angers', 'short' => 'Boquette', 'prefix' => 'an', 'address' => '2 Boulevard du Ronceray, 49100 Angers', 'lat' => 47.4751627, 'lng' => -0.5593541, 'photo' => 'campus/boquette.jpg'],
            ['name' => 'Tabagn\'s de Siber\'s', 'city' => 'Metz', 'short' => 'Siber\'s', 'prefix' => 'me', 'address' => '4 Rue Augustin Fresnel, 57070 Metz', 'lat' => 49.094651, 'lng' => 6.226145, 'photo' => 'campus/sibers.jpg'],
            ['name' => 'Institut de Chambéry', 'city' => 'Chambéry', 'short' => 'Chambéry', 'prefix' => null, 'address' => 'Savoie Technolac, 73370 Le Bourget-du-Lac', 'lat' => 45.6431518, 'lng' => 5.870204, 'photo' => 'campus/chambery.jpg'],
            ['name' => 'Insitut de Bastia', 'city' => 'Bastia', 'short' => 'Bastia', 'prefix' => null, 'address' => '2 Avenue Emile Sari, 20200 Bastia', 'lat' => 42.7036804, 'lng' => 9.4520107, 'photo' => 'campus/bastia.jpg'],
            ['name' => 'Institut de Chalon-sur-Saône', 'city' => 'Chalon-sur-Saône', 'short' => 'Chalon-sur-Saône', 'prefix' => null, 'address' => '2 Rue Thomas Dumorey 71100 Chalon-sur-Saône', 'lat' => 46.775802, 'lng' => 4.857652, 'photo' => 'campus/chalon.jpg'],
            ['name' => 'Institut de Laval', 'city' => 'Laval', 'short' => 'Laval', 'prefix' => null, 'address' => '4 Rue de l\'Ermitage, 53000 Laval', 'lat' => 48.0774403, 'lng' => -0.7719646, 'photo' => 'campus/laval.jpg'],
            ['name' => 'Campus de P3', 'city' => 'Paris', 'short' => 'P3', 'prefix' => 'pa', 'address' => '151 Boulevard de l\'Hôpital, 75013 Paris', 'lat' => 48.8336064, 'lng' => 2.3583875, 'photo' => 'campus/paris.jpg'],
            ['name' => 'Tabagn\'s de Châlon\'s', 'city' => 'Châlons-en-Champagne', 'short' => 'Châlon\'s', 'prefix' => 'ch', 'address' => 'Rue Saint-Dominique, 51000 Châlons-en-Champagne', 'lat' => 48.8952055, 'lng' => 3.3583826, 'photo' => 'campus/chalons.jpg'],
            ['name' => 'Tabagn\'s de Bordel\'s', 'city' => 'Bordeaux', 'short' => 'Bordel\'s', 'prefix' => 'bo', 'address' => 'Esplanade des Arts et Métiers, 33400 Talence', 'lat' => 44.8204421, 'lng' => -0.5869131, 'photo' => 'campus/talence.jpg'],
        ]);
    }
}
