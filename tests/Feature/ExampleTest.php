<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.Workflow test
     *
     * @return void
     */
    public function testBasicTest()
    {
        $response = $this->get('/api');

        $response->assertStatus(200);
    }
}
