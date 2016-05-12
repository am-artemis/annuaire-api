<?php
namespace Tests\Models;

use Tests\TestCase;

use App\Models\Campus;

class CampusControllerTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
    }

    public function testIndex()
    {
        $nb = 10;

        $campuses = factory(Campus::class, $nb)->create();

        $this->json('GET', 'campuses');

        $this->assertResponseOk();
        $this->assertCount($nb, $this->jsonResponse('data'));

        foreach ($campuses as $campus) {
            $this->seeJson($campus->jsonSerialize());
        }
    }

    public function testShow()
    {
        $campus = factory(Campus::class)->create();

        $this->json('GET', implode('/', ['campuses', $campus->id]));

        $this->assertResponseOk();
        $this->seeJson($campus->jsonSerialize());
    }
}
