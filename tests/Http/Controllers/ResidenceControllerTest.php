<?php
namespace Tests\Models;

use Tests\TestCase;
use App\Models\Residence;

class ResidenceControllerTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->mockTransformer('Residence');
    }

    public function testIndex()
    {
        $this->jsonWithJWT('GET', 'residences');


        $this->assertResponseOk();
        $this->assertCount(Residence::count(), $this->jsonResponse('data'));

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
        $this->seeJson(['transformer' => 'Residence']);
    }

    public function testShow()
    {
        $residence = Residence::first();

        $this->jsonWithJWT('GET', implode('/', ['residences', $residence->id]));

        $this->seeJson(['transformer' => 'Residence']);

    }
}
