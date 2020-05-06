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
        $this->withoutExceptionHandling();

        $respone = $this->get('/');
        $respone->assertStatus(200);
        $respone->assertSeeText(config('app.name'));
    }

    /** @test */
    public function visit_about()
    {
        $respone = $this->get('/about');
        $respone->assertStatus(200);
        $respone->assertSeeText('About');
    }

    /** @test */
    public function visit_news()
    {
        $respone = $this->get('/news');
        $respone->assertStatus(200);
        $respone->assertSeeText('News');
    }

    /** @test */
    public function visit_contact_us()
    {
        $respone = $this->get('/contact-us');
        $respone->assertStatus(200);
        $respone->assertSeeText('Get in Touch');
    }

    /** @test */
    public function visit_faq()
    {
        //$this->seed(FaqTableSeeder::class);

        $respone = $this->get('/faq');
        $respone->assertStatus(200);
    }
}
