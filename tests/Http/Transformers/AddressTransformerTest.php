<?php
namespace Tests\Models;

use Tests\TestCase;

use App\Models\User;
use App\Models\Address;
use App\Http\Transformers\AddressTransformer;

class AddressTransformerTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
    }

    public function testFull()
    {
        $addressArray = [
            'user_id' => $this->user->id,
            'name'    => $this->faker->title,
            'address' => $this->faker->streetAddress,
            'zipcode' => '12345',
            'city'    => $this->faker->city,
            'country' => $this->faker->country,
            'lat'     => $this->faker->latitude(),
            'lng'     => $this->faker->longitude(),
            'phone'   => 0612345678,
            'from'    => $this->faker->date(),
            'to'      => $this->faker->date(),
            'type'    => ['perso', 'family'][rand(0, 1)],
        ];

        $address = Address::forceCreate($addressArray);

        $expectedTransformed = [
            'data' => [
                'self'    => url(implode('/', ['users', $this->user->id, 'addresses', $address->id])),
                'name'    => $addressArray['name'],
                'address' => $addressArray['address'],
                'zipcode' => $addressArray['zipcode'],
                'city'    => $addressArray['city'],
                'country' => $addressArray['country'],
                'pos'     => [
                    'lat' => $addressArray['lat'],
                    'lng' => $addressArray['lng'],
                ],
                'phone'   => $addressArray['phone'],
                'from'    => $addressArray['from'],
                'to'      => $addressArray['to'],
                'type'    => $addressArray['type'],
            ],
        ];

        $transformed = self::transformItem($address, new AddressTransformer);

        $this->assertTrue(is_array($transformed));
        $this->assertEquals($expectedTransformed, $transformed);
    }

    public function testNoDates()
    {
        $addressArray = [
            'user_id' => $this->user->id,
            'name'    => $this->faker->title,
            'address' => $this->faker->streetAddress,
            'zipcode' => '12345',
            'city'    => $this->faker->city,
            'country' => $this->faker->country,
            'lat'     => $this->faker->latitude(),
            'lng'     => $this->faker->longitude(),
            'phone'   => 0612345678,
            'type'    => ['perso', 'family'][rand(0, 1)],
        ];

        $address = Address::forceCreate($addressArray);

        $expectedTransformed = [
            'data' => [
                'self'    => url(implode('/', ['users', $this->user->id, 'addresses', $address->id])),
                'name'    => $addressArray['name'],
                'address' => $addressArray['address'],
                'zipcode' => $addressArray['zipcode'],
                'city'    => $addressArray['city'],
                'country' => $addressArray['country'],
                'pos'     => [
                    'lat' => $addressArray['lat'],
                    'lng' => $addressArray['lng'],
                ],
                'phone'   => $addressArray['phone'],
                'from'    => null,
                'to'      => null,
                'type'    => $addressArray['type'],
            ],
        ];

        $transformed = self::transformItem($address, new AddressTransformer);

        $this->assertTrue(is_array($transformed));
        $this->assertEquals($expectedTransformed, $transformed);
    }
}
