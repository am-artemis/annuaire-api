<?php
namespace Tests\Models;

use Tests\TestCase;

use App\Models\User;
use App\Models\Gadz;
use App\Models\Campus;
use App\Http\Transformers\GadzTransformer;

class GadzTransformerTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
    }

    public function testTransformer()
    {
        $gadzArray = [
            'buque'      => 'Iwazaru',
            'fams'       => '134μ169',
            'famsSearch' => '134, 169',
            'proms'      => (int)212,
            'user_id'    => $this->user->id,
        ];


        $gadz = Gadz::forceCreate($gadzArray);

        $expectedTransformed = [
            'data' => [
                'buque'      => 'Iwazaru',
                'fams'       => '134μ169',
                'famsSearch' => '134, 169',
                'proms'      => 212,
            ],
        ];

        $transformed = self::transformItem($gadz, new GadzTransformer);
        $this->assertTrue(is_array($transformed));
        $this->assertEquals($expectedTransformed, $transformed);
    }
}
