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

        $this->jsonWithJWT('GET', 'campuses');

        $this->assertResponseOk();
        $this->assertCount($nb, $this->jsonResponse('data'));

        $expectedJsonStruture = [
            'data' => [
                ['self', 'id', 'name', 'city', 'short', 'prep', 'prefix', 'address', 'pos', 'photo']
            ],
            'meta' => [
                "pagination" => [
                    "total", "count", "per_page", "current_page", "total_pages", "links"
                ],
            ],
        ];

        $this->seeJsonStructure($expectedJsonStruture);
    }

    public function testShow()
    {
        $campus = factory(Campus::class)->create();

        $this->jsonWithJWT('GET', implode('/', ['campuses', $campus->id]));

        $this->assertResponseOk();

        $expectedJsonStruture = [
            'data' => ['self', 'id', 'name', 'city', 'short', 'prep', 'prefix', 'address', 'pos', 'photo']
        ];

        $this->seeJsonStructure($expectedJsonStruture);
    }
}
