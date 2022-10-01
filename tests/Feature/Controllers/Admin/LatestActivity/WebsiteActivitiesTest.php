<?php

namespace Tests\Feature\Controllers\Admin\LatestActivity;

use Bpocallaghan\LogActivity\Models\LogActivity;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WebsiteActivitiesTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    protected $path = '/admin/activities/website';

    protected $viewPath = 'admin.latest_activities.website';

    /** @test */
    public function guests_cannot_view()
    {
        $this->get($this->path)->assertRedirect($this->loginPath);
    }

    /** @test */
    public function authenticated_user_can_view()
    {
        $this->signInAdmin();

        $this->get($this->path)->assertStatus(200)->assertViewIs($this->viewPath);
    }

//    /** @test */
//    public function list_items()
//    {
//        $this->signInAdmin();
//        $items = factory(LogActivity::class)->create([
//            'name' => 'Example Activity',
//            'description' => 'More information',
//        ]);
//
//        $response = $this->get($this->path);
//
//        $response->assertStatus(200);
//        $response->assertViewHas('items');
//        $response->assertSee('Example Activity');
//        $response->assertSee('More information');
//    }
}
