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
        $this->jsonWithJWT('GET', 'campuses');

        $this->assertResponseOk();
        $this->assertCount(Campus::count(), $this->jsonResponse('data'));

        $expectedJsonStructure = [
            'data' => [
                ['self', 'id', 'name', 'city', 'short', 'prep', 'prefix', 'address', 'pos', 'photo']
            ],
            'meta' => [
                "pagination" => [
                    "total", "count", "per_page", "current_page", "total_pages", "links"
                ],
            ],
        ];

        $this->seeJsonStructure($expectedJsonStructure);
    }

    public function testShow()
    {
        $campus = Campus::first();

        $this->jsonWithJWT('GET', implode('/', ['campuses', $campus->id]));

        $this->assertResponseOk();

        $expectedJsonStructure = [
            'data' => ['self', 'id', 'name', 'city', 'short', 'prep', 'prefix', 'address', 'pos', 'photo']
        ];

        $this->seeJsonStructure($expectedJsonStructure);
    }
}
