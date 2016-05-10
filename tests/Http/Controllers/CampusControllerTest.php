<?php
namespace Tests\Models;

use App\Models\Campus;
use Tests\TestCase;

class CampusControllerTest extends TestCase
{

    public function setUp()
    {
        parent::setUp();
    }


    /**
     * TODO ZARU Ce n'est pas ce que fais le controller, il faut faire ça pour le transformer, et pas seeJson mais exactement ce qui est renvoyé.
     */
    public function testRecupererTousLesCampus()
    {
        $campusArray = ['name' => 'Tabagn\'s de Clun\'s', 'city' => 'Cluny', 'short' => 'Clun\'s', 'prefix' => 'cl', 'address' => 'Rue porte de Paris, 71250 Cluny', 'lat' => 46.2157467, 'lng' => 2.2088258, 'photo' => 'campus/cluns.jpg'];
        Campus::create($campusArray);

        $this->json('GET', 'campuses');

        $this->assertResponseOk();
        $this->assertCount(1, $this->jsonResponse('data'));
        $this->seeJson($campusArray);
    }


}
