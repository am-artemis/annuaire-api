<?php
namespace Tests\Models;

use Tests\TestCase;

use App\Models\User;
use App\Models\Job;
use App\Http\Transformers\JobTransformer;

class JobTransformerTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
    }

    public function testTransformerwithoutTo()
    {
        $jobArray = [
            'title'       => $title = $this->faker->title,
            'description' => $description = $this->faker->words(3, true),
            'user_id'     => $this->user->id,
            'from'        => $from = $this->faker->date(),
        ];

        $job = Job::forceCreate($jobArray);

        $expectedTransformed = [
            'data' => [
                'self'        => url(implode('/', ['users', $this->user->id, 'jobs', $job->id])),
                'title'       => $title,
                'description' => $description,
                /* TODO : Tarmak à rajouter ??
                 * 'user'        => [
                    'self' => url('users', $this->user->id),
                ],*/
                'from'        => $from,
                'to'          => null,
            ],
        ];


        $transformed = self::transformItem($job, new JobTransformer);

        $this->assertTrue(is_array($transformed));
        $this->assertEquals($expectedTransformed, $transformed);
    }

    public function testTransformerwithTo()
    {
        $jobArray = [
            'title'       => $title = $this->faker->title,
            'description' => $description = $this->faker->words(3, true),
            'user_id'     => $this->user->id,
            'from'        => $from = $this->faker->date(),
            'to'          => $to = $this->faker->date(),
        ];

        $job = Job::forceCreate($jobArray);

        $expectedTransformed = [
            'data' => [
                'self'        => url(implode('/', ['users', $this->user->id, 'jobs', $job->id])),
                'title'       => $title,
                'description' => $description,
                /* TODO : Tarmak à rajouter ??
                 * 'user'        => [
                    'self' => url('users', $this->user->id),
                ],*/
                'from'        => $from,
                'to'          => $to,
            ],
        ];


        $transformed = self::transformItem($job, new JobTransformer);

        $this->assertTrue(is_array($transformed));
        $this->assertEquals($expectedTransformed, $transformed);
    }
}
