<?php
namespace Tests\Models;

use Tests\TestCase;

use App\Models\User;
use App\Models\Photo;
use App\Models\Campus;

class PhotoControllerTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        // Create a Campus for user factory
        factory(Campus::class)->create();

        $this->user = factory(User::class)->create();
    }

    public function testIndex()
    {
        $nb = 10;

        $user = $this->user;

        $photos = factory(Photo::class, $nb)->make()->each(function (\App\Models\Photo $photo) use ($user) {
            $photo->user()->associate($user)->save();
        });

        $this->json('GET', 'photos');

        $this->assertResponseOk();
        $this->assertCount($nb, $this->jsonResponse('data'));

        $expectedJsonStruture = [
            'data' => [
                ['self', 'src', 'type', 'title', 'user']
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
        $user = $this->user;
        $photo = factory(Photo::class)->make();
        $photo->user()->associate($user)->save();

        $this->json('GET', implode('/', ['photos', $photo->id]));

        $this->assertResponseOk();

        $expectedJsonStruture = [
            'data' => ['self', 'src', 'type', 'title', 'user']
        ];

        $this->seeJsonStructure($expectedJsonStruture);
    }

    public function testDestroy()
    {
        $user = $this->user;
        $photo = factory(Photo::class)->make();
        $photo->user()->associate($user)->save();

        $this->delete(implode('/', ['photos', $photo->id]));

        $this->assertResponseStatus(202);

        $this->assertTrue(is_null(Photo::find($photo->id)));
    }
}
