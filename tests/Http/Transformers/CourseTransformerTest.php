<?php
namespace Tests\Transformers;

use Tests\TestCase;

use App\Models\User;
use App\Models\Campus;
use App\Models\Course;
use App\Http\Transformers\CourseTransformer;

class CourseTransformerTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->mockTransformer('Campus');
        $this->user = factory(User::class)->create();
    }

    public function testWithCampusOnly()
    {
        $campus = Campus::all()->random();
        $courseArray = [
            'campus_id'   => $campus->id,
            'title'       => $this->faker->title,
            'description' => $this->faker->words(3, true),
            'school'      => 'Rien d\'important normalement...',
        ];

        $course = Course::forceCreate($courseArray);

        $expectedTransformed = [
            'data' => [
                'self'        => url('courses', $course->id),
                'title'       => $courseArray['title'],
                'description' => $courseArray['description'],
                'campus'      => ['transformer' => 'Campus'],
                'school'      => null,
            ],
        ];

        $transformed = self::transformItem($course, new CourseTransformer);

        $this->assertTrue(is_array($transformed));
        $this->assertEquals($expectedTransformed, $transformed);
    }

    public function testWithSchoolOnly()
    {
        $courseArray = [
            'campus_id'   => null,
            'title'       => $this->faker->title,
            'description' => $this->faker->words(3, true),
            'school'      => 'Ecole random',
        ];

        $course = Course::forceCreate($courseArray);

        $expectedTransformed = [
            'data' => [
                'self'        => url('courses', $course->id),
                'title'       => $courseArray['title'],
                'description' => $courseArray['description'],
                'campus'      => null,
                'school'      => $courseArray['school'],
            ],
        ];

        $transformed = self::transformItem($course, new CourseTransformer);

        $this->assertTrue(is_array($transformed));
        $this->assertEquals($expectedTransformed, $transformed);
    }

    public function testWithUserAndCampus()
    {
        $campus = Campus::all()->random();
        $courseArray = [
            'campus_id'   => $campus->id,
            'title'       => $this->faker->title,
            'description' => $this->faker->words(3, true),
            'school'      => 'Rien d\'important normalement...',
        ];
        $pivotArray = [
            'from' => $this->faker->date(),
            'to'   => $this->faker->date(),
        ];

        $course = Course::forceCreate($courseArray);
        $course->users()->attach($this->user->id, $pivotArray);
        
        // Reload course with pivot
        $course = $this->user->courses()->find($course->id);

        $expectedTransformed = [
            'data' => [
                'self'        => url(implode('/', ['users', $course->pivot->user_id, 'courses', $course->pivot->id])),
                'title'       => $courseArray['title'],
                'description' => $courseArray['description'],
                'campus'      => ['transformer' => 'Campus'],
                'school'      => null,
                'from' => $pivotArray['from'],
                'to' => $pivotArray['to'],
            ],
        ];

        $transformed = self::transformItem($course, new CourseTransformer);

        $this->assertTrue(is_array($transformed));
        $this->assertEquals($expectedTransformed, $transformed);
    }
}
