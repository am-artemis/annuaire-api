<?php

use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testHome()
    {
        $this->get('/');

        $this->assertEquals($this->app->version(), $this->response->getContent());
    }
}
