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

    public function testTransformer()
    {
        $campusArray = [
            'name' => 'Tabagn\'s de Clun\'s',
            'city' => 'Cluny',
            'short' => 'Clun\'s',
            'prefix' => 'cl',
            'address' => 'Rue porte de Paris, 71250 Cluny',
            'lat' => 46.2157467,
            'lng' => 2.2088258,
            'photo' => 'campus/cluns.jpg'
        ];

        $campus = Campus::create($campusArray);
        $expectedTransformed = [
            'data' => [
                'self' => 'http://api.annuaire.artemis.am/campuses/'.$campus->id,
                'id' => $campus->id,
                'name' => 'Tabagn\'s de Clun\'s',
                'city' => 'Cluny',
                'short' => 'Clun\'s',
                'prep' => '["du","au"]',
                'prefix' => 'cl',
                'address' => 'Rue porte de Paris, 71250 Cluny',
                'pos' => [
                    'lat' => 46.2157467,
                    'lng' => 2.2088258,
                ],
                'photo' => url('campus/cluns.jpg'),
            ]
        ];

        $transformed = self::transformItem($campus, new CampusTransformer);

        $this->assertTrue(is_array($transformed));
        $this->assertEquals($expectedTransformed, $transformed);
    }
}
