<?php
namespace Tests\Models;

use Tests\TestCase;

use App\Models\Campus;
use App\Http\Transformers\CampusTransformer;

use League\Fractal\Resource\Item;

class CampusTransformerTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
    }

    public function testTransformer()
    {
        $campus = factory(Campus::class)->make();

        $transformed = new Item($campus, new CampusTransformer);

        $array = $this->serialize($transformed);

        $this->assertTrue(is_array($array));
    }
}
