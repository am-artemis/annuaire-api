<?php
namespace Tests\Models;

use Tests\TestCase;
use App\Models\Campus;

class CampusControllerTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->mockTransformer('Campus');
    }

    public function testIndex()
    {
        $this->jsonWithJWT('GET', 'campuses');

        $this->assertResponseOk();
        $this->assertCount(Campus::count(), $this->jsonResponse('data'));

        $expectedJsonStructure = [
            'data' => [
                ['transformer']
            ],
            // 'meta' => [
            //     "pagination" => [
            //         "total", "count", "per_page", "current_page", "total_pages", "links"
            //     ],
            // ],
        ];

        $this->seeJsonStructure($expectedJsonStructure);
        $this->seeJson(['transformer' => 'Campus']);
    }

    public function testShow()
    {
        $campus = Campus::first();

        $this->jsonWithJWT('GET', implode('/', ['campuses', $campus->id]));

        $this->seeJson(['transformer' => 'Campus']);

    }
}
