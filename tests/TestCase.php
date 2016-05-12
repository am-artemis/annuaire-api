<?php


namespace Tests;

use App\Models\User;
use Faker\Factory;
use Faker\Generator;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\TestCase as LaravelTestCase;

use League\Fractal\Manager;
use League\Fractal\Serializer\DataArraySerializer;

class TestCase extends LaravelTestCase
{
    use DatabaseMigrations;

    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl = 'http://api.dev';

    /**
     * @var Generator
     */
    protected $faker;

    /**
     * @var User
     */
    protected $user;

    public function setUp()
    {
        $this->faker = Factory::create();

        parent::setUp();
    }

    public function tearDown()
    {
        parent::tearDown();

        $refl = new \ReflectionObject($this);
        foreach ($refl->getProperties() as $prop) {
            if (!$prop->isStatic() && 0 !== strpos($prop->getDeclaringClass()->getName(), 'PHPUnit_')) {
                $prop->setAccessible(true);
                $prop->setValue($this, null);
            }
        }
    }

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__ . '/../bootstrap/app.php';

        $app->make(Kernel::class)->bootstrap();

        return $app;
    }

    /**
     * Return the response json as an array or a specific inside this response
     *
     * @param  string  $key
     * @return mixed
     */
    protected function jsonResponse($key = null)
    {
        $response = json_decode($this->response->getContent(), true);

        if ($key) {
            return array_get($response, $key);
        } else {
            return $response;
        }
    }

    /**
     * Return the response json as an array or a specific inside this response
     *
     * @param  string  $key
     * @return mixed
     */
    protected function serialize($resource)
    {
        $manager = new Manager();
        $manager->setSerializer(new DataArraySerializer());

        return $manager->createData($resource)->toArray();
    }
}
