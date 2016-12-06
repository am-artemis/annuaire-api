<?php

use App\Models\Campus;
use Illuminate\Database\Migrations\Migration;

class PopulateResidences extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('residences')->insert([
            ['name' => 'Ancienne Résid\'s', 'address' => 'Rue porte de paris, 71250 Cluny', 'lat' => 154, 'lng' => 154, 'campus_id' => $this->campus('cl')],
            ['name' => 'Nouvelle Résid\'s', 'address' => '20 Rue porte de Paris, 71250 Cluny', 'lat' => 154, 'lng' => 154, 'campus_id' => $this->campus('cl')],
            ['name' => 'Ancienne Maison', 'address' => '1 avenue Pierre Masset, 75014 Paris', 'lat' => 154, 'lng' => 154, 'campus_id' => $this->campus('pa')],
            ['name' => 'Rez', 'address' => '', 'lat' => 154, 'lng' => 134, 'campus_id' => $this->campus('kin')],
            ['name' => 'Rez', 'address' => '', 'lat' => 154, 'lng' => 134, 'campus_id' => $this->campus('an')],
            ['name' => 'Rez', 'address' => '', 'lat' => 154, 'lng' => 134, 'campus_id' => $this->campus('bo')],
        ]);
    }

    private function campus($short)
    {
        return Campus::whereShort($short)->first('id')->id;
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('residences')->truncate();
    }
}
