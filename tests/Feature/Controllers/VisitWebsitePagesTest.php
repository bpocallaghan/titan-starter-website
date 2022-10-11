<?php

namespace Tests\Feature\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VisitWebsitePagesTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->seedPages();
    }

    /** @test */
    public function visit_home()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSeeText(config('app.name'));
    }

    /** @test */
    public function visit_about()
    {
        $response = $this->get('/about');
        $response->assertStatus(200);
        $response->assertSeeText('About');
    }

    /** @test */
    public function visit_news()
    {
        $response = $this->get('/news');
        $response->assertStatus(200);
        $response->assertSeeText('News');
    }

    /** @test */
    public function visit_contact_us()
    {
        $response = $this->get('/contact-us');
        $response->assertStatus(200);
        $response->assertSeeText('Get in Touch');
    }

    /** @test */
    public function visit_faq()
    {
        //$this->seed(FaqTableSeeder::class);

        $response = $this->get('/faq');
        $response->assertStatus(200);
    }
}
