<?php
namespace Tests\Models;

use App\Models\Campus;
use Tests\TestCase;

class CampusTransformerTest extends TestCase
{

    public function setUp()
    {
        parent::setUp();
    }


    public function testRecupererTousLesCampus()
    {
        /*
         * TODO TARMAK : A refaire
         * Ca test pas grand chose là, et c'est un hasard que ça marche.
         * On fait à la fois controller pour le GET, et le transformer pour le json..
         */
        $campusArray = ['name' => 'Tabagn\'s de Clun\'s', 'city' => 'Cluny', 'short' => 'Clun\'s', 'prefix' => 'cl', 'address' => 'Rue porte de Paris, 71250 Cluny', 'lat' => 46.2157467, 'lng' => 2.2088258, 'photo' => 'campus/cluns.jpg'];
        Campus::create($campusArray);

        $this->json('GET', 'campuses');

        $this->assertResponseOk();
        $this->assertCount(1, $this->jsonResponse('data'));
        $this->seeJson($campusArray);
    }


}
