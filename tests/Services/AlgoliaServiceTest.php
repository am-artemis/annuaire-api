<?php

namespace Tests\Models;

use AlgoliaSearch\Index;
use App\Models\User;
use App\Services\AlgoliaService;
use Carbon\Carbon;
use Tests\TestCase;
use Mockery as m;
use Vinkla\Algolia\AlgoliaManager;

class AlgoliaServiceTest extends TestCase
{
    /** @var AlgoliaService $service */
    protected $service;

    /** @var Index | m\Mock $index */
    protected $index;

    /** @var AlgoliaManager | m\Mock $manager */
    protected $manager;

    public function setUp()
    {
        parent::setUp();

        $this->index = m::mock(Index::class);

        $this->manager = m::mock(AlgoliaManager::class);
        $this->manager->shouldReceive('initIndex')->once()->andReturn($this->index);

        $this->service = new AlgoliaService($this->manager);
    }

    public function testuserToObjects()
    {
        $this->seedCustomUsers();
        $zaru = User::find('000001');
        $zaruArray = $this->service->userToObjects($zaru);
        $expectedArray = [
            [
                'user_id' => '000001',
                'firstname' => 'Mathieu',
                'lastname' => 'TUDISCO',
                'birthday' => 673660800,
                'email' => 'mathieu.tudisco',
                'phone' => '0625690445',
                'year' => '2012',
                'campus' => ['Cluny', 'Clun\'s', 'Clun\'ss', 'Clun\'sss', 'Clun\'ssss'],
                'buque' => 'Iwazaru',
                'proms' => '212',
                'promsTBK' => 'cl212',
                'fams' => ['134', ' 169'],
                'famsPromsTBK' => ['134cl212', ' 169cl212', '134- 169cl212'],
                'tags' => ['zaru', ' charue'],
                'rank' => [ 'isStudent' => 0, 'isGadz' => 1, 'year' => 2012],
            ],
        ];

        $this->assertEquals($expectedArray, $zaruArray);
    }

    public function testAjouterUnUser()
    {
        $user = $this->creerUnUser();
        $this->index->shouldReceive('addObjects')->once()->andReturnNull();
        $this->service->addUser($user);
    }

    public function testSupprimerUnUser()
    {
        $user = $this->creerUnUser();
        $this->index->shouldReceive('deleteByQuery')->andReturnNull();
        $this->service->deleteUser($user);
    }

    public function testreIndexUsers()
    {
        $this->seedCustomUsers();
        $this->manager->shouldReceive('initIndex')->once()->andReturn($this->index);
        $this->manager->shouldReceive('moveIndex');
        $this->index->shouldReceive('addObjects');
        $this->index->shouldReceive('setSettings');
        $this->service->reIndexUsers();
    }

    public function testSearchUsers()
    {
        $this->index->shouldReceive('search')->with('essai', ['foo', 'bar']);
        $this->service->searchUsers('essai', ['foo', 'bar']);

    }

    public function testUpdateUser()
    {
        $user = $this->creerUnUser();
        $this->index->shouldReceive('deleteByQuery')->once()->andReturnNull();
        $this->index->shouldReceive('addObjects')->once()->andReturnNull();
        $this->service->updateUser($user);

    }

    protected function creerUnUser($attributesUser = [], $attributesGadz = [])
    {
        /** @var User $user*/
        $user = factory(User::class)->create($attributesUser);
        $user->gadz()->save($gadz = factory(\App\Models\Gadz::class)->make(['proms' => $user->year - 200] + $attributesGadz));
        $user->degrees()->attach($degree = factory(\App\Models\Degree::class)->create()->id, ['year' =>2012]);
        return $user;
    }

    public function seedCustomUsers()
    {
        $seeder = $this->app->make(\CustomUserSeeder::class);
        $seeder->run();
    }
}
