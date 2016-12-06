<?php
namespace Tests\Models;

use Tests\TestCase;

use App\Models\Campus;
use App\Http\Transformers\CampusTransformer;

class CampusTransformerTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
    }

    public function testTabagns()
    {
        $campus = Campus::wherePrefix('cl')->first();
        $expectedTransformed = [
            'data' => [
                'self'    => 'http://api.annuaire.artemis.am/campuses/' . $campus->id,
                'id'      => $campus->id,
                'name'    => 'Tabagn\'s de Clun\'s',
                'city'    => 'Cluny',
                'short'   => 'Clun\'s',
                'prep'    => '["du","au"]',
                'prefix'  => 'cl',
                'address' => 'Rue porte de Paris, 71250 Cluny',
                'pos'     => [
                    'lat' => 46.2157467,
                    'lng' => 2.2088258,
                ],
                'photo'   => url('img/campus/cluns.jpg'),
            ],
        ];

        $transformed = self::transformItem($campus, new CampusTransformer);

        $this->assertTrue(is_array($transformed));
        $this->assertEquals($expectedTransformed, $transformed);
    }

    public function testBoquette()
    {
        $campus = Campus::wherePrefix('an')->first();
        $expectedTransformed = [
            'data' => [
                'self'    => 'http://api.annuaire.artemis.am/campuses/' . $campus->id,
                'id'      => $campus->id,
                'name'    => 'Boquette d\'Angers',
                'city'    => 'Angers',
                'short'   => 'Boquette',
                'prep'    => '["de la","à la"]',
                'prefix'  => 'an',
                'address' => '2 Boulevard du Ronceray, 49100 Angers',
                'pos'     => [
                    'lat' => 47.475162699999998,
                    'lng' => -0.55935409999999997,
                ],
                'photo'   => url('img/campus/boquette.jpg'),
            ],
        ];

        $transformed = self::transformItem($campus, new CampusTransformer);

        $this->assertTrue(is_array($transformed));
        $this->assertEquals($expectedTransformed, $transformed);
    }

    public function testBastia()
    {
        $campus = Campus::whereCity('Bastia')->first();
        $expectedTransformed = [
            'data' => [
                'self'    => 'http://api.annuaire.artemis.am/campuses/' . $campus->id,
                'id'      => $campus->id,
                'name' => 'Insitut de Bastia',
                'city' => 'Bastia',
                'short' => 'Bastia',
                'prep' => '["de l\'", "à l\'"]',
                'prefix' => NULL,
                'address' => '2 Avenue Emile Sari, 20200 Bastia',
                'pos' => [
                        'lat' => 42.703680400000003,
                        'lng' => 9.4520107000000007,
                ],
                'photo'   => url('img/campus/bastia.jpg'),
            ],

        ];

        $transformed = self::transformItem($campus, new CampusTransformer);

        $this->assertTrue(is_array($transformed));
        $this->assertEquals($expectedTransformed, $transformed);
    }

}
