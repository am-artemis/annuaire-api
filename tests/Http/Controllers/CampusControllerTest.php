<?php
namespace Tests\Models;

use App\Http\Transformers\CampusTransformer;
use Tests\TestCase;

use App\Models\Campus;
use Mockery as m;

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
            ]
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
