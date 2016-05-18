<?php
namespace Tests\Models;

use Tests\TestCase;

use App\Models\User;
use App\Models\Photo;
use App\Models\Campus;
use App\Http\Transformers\PhotoTransformer;

class PhotoTransformerTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        // Create a Campus for user factory
        factory(Campus::class)->create();
        $this->user = factory(User::class)->create();
    }

    public function testTransformer()
    {
        $photoArray = [
            'src' => 'http://random.photo/photo.png',
            'type' => 'profile',
            'title' => 'Aut repellendus voluptatum voluptatem in.',
            'user_id' => $this->user->id,
        ];

        $photo = Photo::forceCreate($photoArray);

        $expectedTransformed = [
            'data' => [
                'self' => url('photos', $photo->id),
                'src' => 'http://random.photo/photo.png',
                'type' => 'profile',
                'title' => 'Aut repellendus voluptatum voluptatem in.',
                'user' => [
                    'self' => url('users', $this->user->id),
                ]
            ]
        ];

        $transformed = self::transformItem($photo, new PhotoTransformer);

        $this->assertTrue(is_array($transformed));
        $this->assertTrue($transformed == $expectedTransformed);
    }
}
