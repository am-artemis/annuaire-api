<?php


namespace Tests;

use App\Models\User;
use Faker\Factory;
use Faker\Generator;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\TestCase as LaravelTestCase;

use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use League\Fractal\Serializer\DataArraySerializer;
use Tymon\JWTAuth\JWTAuth;


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
     * Visit the given URI with a JSON request with the JWT of the authenticated user
     *
     * @param  string $method
     * @param  string $uri
     * @param  array  $data
     * @param  array  $headers
     *
     * @return $this
     */
    protected function jsonWithJWT($method, $uri, $data = [], $headers = [])
    {
        $this->user = $this->user ?: factory(User::class)->create();
        $auth = $this->app->make(JWTAuth::class);
        $token = $auth->fromUser($this->user);

        return $this->json($method, $uri, $data, $headers + ['Authorization' => 'Bearer ' . $token]);
    }

    /**
     * Asserts that a response contains a valid JWT
     *
     * @return void
     */
    protected function assertResponseContainsValidToken()
    {
        $auth = $this->app->make(JWTAuth::class);
        try {
            $this->seeJsonStructure(['token']);
            $token = $this->decodeResponseJson()['token'];
        } catch (\Exception $e) {
            $this->seeHeader('Authorization');
            $token = trim(str_ireplace('bearer', '', $this->response->headers->get('Authorization')));
        }

        $this->assertInstanceOf(User::class, $auth->toUser($token));
    }

    /**
     * Return the response json as an array or a specific inside this response
     *
     * @param string $resource
     * @return mixed
     */
    public static function transformItem($data = null, $transformer = null, $resourceKey = null)
    {
        // Set up tools to tranform
        $manager = new Manager();
        $manager->setSerializer(new DataArraySerializer());

        $resource = new Item($data, $transformer, $resourceKey);

        return $manager->createData($resource)->toArray();
    }
}
