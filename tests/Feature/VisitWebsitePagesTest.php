<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VisitWebsitePagesTest extends TestCase
{
    /** @test */
    public function home()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
