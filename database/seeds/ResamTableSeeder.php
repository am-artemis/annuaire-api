<?php

use Illuminate\Database\Seeder;

use App\Models\Campus;

class ResamTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('resams')->insert(
            [
                ['name' => 'Acienne Résid\'s', 'address' => 'Rue porte de paris, 71250 Cluny', 'lat' => 154, 'lng' => 154, 'campus_id' => Campus::where('city', 'Cluny')->first()->id],
                ['name' => 'Nouvelle Résid\'s', 'address' => '20 Rue porte de Paris, 71250 Cluny', 'lat' => 154, 'lng' => 154, 'campus_id' => Campus::where('city', 'Cluny')->first()->id],
                ['name' => 'Maison des Arts et Métiers', 'address' => '1 avenue Pierre Masset, 75014 Paris', 'lat' => 154, 'lng' => 154, 'campus_id' => Campus::where('city', 'Paris')->first()->id],
                ['name' => 'Rez1', 'address' => '', 'lat' => 154, 'lng' => 154, 'campus_id' => Campus::where('city', 'Aix-en-Provence')->first()->id],
                ['name' => 'Rez2', 'address' => '', 'lat' => 154, 'lng' => 154, 'campus_id' => Campus::where('city', 'Angers')->first()->id],
                ['name' => 'Rez3', 'address' => '', 'lat' => 154, 'lng' => 154, 'campus_id' => Campus::where('city', 'Metz')->first()->id],
            ]);
    }
}
