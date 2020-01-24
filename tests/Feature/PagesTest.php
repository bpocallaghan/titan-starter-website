<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PagesTest extends TestCase
{

    /** @test */
    public function visit_home()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
