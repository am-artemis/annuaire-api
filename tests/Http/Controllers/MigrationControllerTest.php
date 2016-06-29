<?php

namespace Tests\Http\Controllers\Api;

use Artisan;
use Config;
use App;
use Mockery as m;
use Tests\TestCase;

class MigrationControllerTest extends TestCase
{
    /** @var m\Mock $migrator*/
    protected $migrator;

    protected $migrationRepository;

    public function setUp()
    {
        parent::setUp();

        $this->migrationRepository = m::mock('Illuminate\Database\Migrations\DatabaseMigrationRepository');
        $this->migrator = m::mock('Illuminate\Database\Migrations\Migrator');
        $this->migrator->shouldReceive('getRepository')->andReturn($this->migrationRepository);

        App::singleton('migrator', function () {
            return $this->migrator;
        });
    }

    public function testLancementDesMigrations()
    {
        $this->migrator->shouldReceive('repositoryExists')->andReturn(true);
        $this->migrator->shouldReceive('run')->once();
        $this->migrator->shouldReceive('getNotes')->andReturn(['Migrations done']);
        $this->post('migrate', ['token' => Config::get('app.admin_token')]);

        $this->assertResponseStatus(200);
        $this->dontSee('Migration table created successfully');
        $this->see('Migrations done');
    }

    public function testLancementDesMigrationsSansTableMigration()
    {
        $this->migrator->shouldReceive('repositoryExists')->andReturn(false);
        $this->migrationRepository->shouldReceive('createRepository')->once();
        $this->migrator->shouldReceive('run')->once();
        $this->migrator->shouldReceive('getNotes')->andReturn(['Migrations done']);

        $this->post('migrate', ['token' => Config::get('app.admin_token')]);

        $this->assertResponseStatus(200);
        $this->see('Migration table created successfully');
        $this->see('Migrations done');
    }

    public function testLancementDesMigrationsSansAuthentification()
    {
        $this->post('migrate', ['token' => '']);

        $this->assertResponseStatus(401);
        $this->see('Unauthorized');
    }
}
