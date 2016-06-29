<?php

namespace App\Http\Controllers;

use Config;
use Illuminate\Foundation\Application as App;
use Illuminate\Http\Request;

class MigrationController extends Controller
{
    public function migrate(App $app, Request $request)
    {
        if ($request->input('token') !== Config::get('app.admin_token')) {
            return response('Unauthorized', 401);
        }

        if (env('APP_ENV') !== 'testing') {
            $default = config('database.default');
            $database = config('database.connections.' . $default . '.database');
            $connection = \DB::connection($default . '-root');
            $connection->statement("CREATE SCHEMA IF NOT EXISTS $database CHARSET utf8");
            $result = 'Database existance checked.';
        } else {
            $result = '';
        }
        /** @var \Illuminate\Database\Migrations\Migrator $migrator */
        $migrator = $app['migrator'];

        if (! $migrator->repositoryExists()) {
            $migrator->getRepository()->createRepository();
            $result .= "Migration table created successfully.\n";
        }

        $migrator->run($app->databasePath() . '/migrations');
        $result .= str_replace(['<info>', '</info>'], '', implode("\n", $migrator->getNotes())) . "\n";

        return response($result, 200);
    }
}
