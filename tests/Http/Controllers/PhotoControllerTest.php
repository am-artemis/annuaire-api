<?php
namespace Tests\Http\Controllers;

use App\Http\Controllers\PhotoController;
use File;
use Illuminate\Http\Request;
use Tests\TestCase;

use App\Models\User;
use App\Models\Photo;
use App\Models\Campus;
use Mockery as m;
use JD\Cloudder\CloudinaryWrapper;


class PhotoControllerTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        // Create a Campus for user factory
        $this->user = factory(User::class)->create();
    }

    public function testIndex()
    {
        $nb = 10;

        $user = $this->user;

        $photos = factory(Photo::class, $nb)->make()->each(function (\App\Models\Photo $photo) use ($user) {
            $photo->user()->associate($user)->save();
        });

        $this->jsonWithJWT('GET', 'photos');

        $this->assertResponseOk();
        $this->assertCount($nb, $this->jsonResponse('data'));

        $expectedJsonStructure = [
            'data' => [
                ['self', 'src', 'type', 'title', 'user']
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
        $user = $this->user;
        $photo = factory(Photo::class)->make();
        $photo->user()->associate($user)->save();

        $this->jsonWithJWT('GET', implode('/', ['photos', $photo->id]));

        $this->assertResponseOk();

        $expectedJsonStructure = [
            'data' => ['self', 'src', 'type', 'title', 'user']
        ];

        $this->seeJsonStructure($expectedJsonStructure);
    }

    public function testAjouterUnePhoto()
    {
        $user = $this->user;

        $cloudder = m::mock(CloudinaryWrapper::class);

        $photo = File::get('tests/Http/Controllers/PhotoControllerTestBase64Image.txt');

        $cloudder->shouldReceive('upload')
            ->once()
            ->with($photo, null, [], ['env_testing'])
            ->andReturn($cloudder)
            ->shouldReceive('getResult')
            ->once()
            ->andReturn(['secure_url' => 'https://essai', 'public_id' => 134])
        ;

        $this->app->bind(CloudinaryWrapper::class, function () use ($cloudder) {
            return $cloudder;
        });

        $this->jsonWithJWT('POST', 'photos', [
            'title'   => 'Titre',
            'type'    => 'profile',
            'user_id' => $user->id,
            'photo' => $photo
        ]);

        $this->assertResponseStatus(201);

        $this->seeInDatabase('photos', [
            'title'         => 'Titre',
            'type'          => 'profile',
            'user_id'       => $user->id,
            'src'           => 'https://essai',
            'cloudinary_id' => 134,
        ]);

        $expectedJsonStructure = [
            'data' => ['self', 'src', 'type', 'title', 'user']
        ];

        $this->seeJsonStructure($expectedJsonStructure);
    }

    public function testModifierUnePhoto()
    {
        $user = $this->user;
        $photo = factory(Photo::class)->make();
        $photo->user()->associate($user)->save();

        $this->jsonWithJWT('PUT', 'photos/' . $photo->id, [
            'title' => 'Un titre',
            'type'  => 'blabla',
        ]);

        $this->assertResponseOk();

        $this->seeInDatabase('photos', [
            'id'      => $photo->id,
            'title'   => 'Un titre',
            'type'    => 'blabla',
            'user_id' => $user->id,
        ]);

        $expectedJsonStructure = [
            'data' => ['self', 'src', 'type', 'title', 'user']
        ];

        $this->seeJsonStructure($expectedJsonStructure);
    }

    public function testDestroy()
    {
        $user = $this->user;
        $photo = factory(Photo::class)->make();
        $photo->user()->associate($user)->save();

        $this->jsonWithJWT('DELETE', implode('/', ['photos', $photo->id]));
        $this->assertResponseStatus(204);

        $this->assertTrue(is_null(Photo::find($photo->id)));
    }
}
