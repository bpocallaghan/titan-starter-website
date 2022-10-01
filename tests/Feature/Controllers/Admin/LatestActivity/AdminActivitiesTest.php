<?php

namespace Tests\Feature\Controllers\Admin\LatestActivity;

use Bpocallaghan\LogActivity\Models\LogModelActivity;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminActivitiesTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    protected $path = '/admin/activities/admin';

    protected $viewPath = 'admin.latest_activities.admin';

    /** @test */
    public function guest_cannot_view()
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
//        $items = factory(LogModelActivity::class)->create([
//            'name'   => 'user_created',
//            'before' => '{"example":"before"}',
//            'after'  => '{"example":"after"}',
//        ]);
//
//        $response = $this->get($this->path);
//
//        $response->assertStatus(200);
//        $response->assertViewHas('items');
//        $response->assertSee('user_created');
//        $response->assertSee('before');
//        $response->assertSee('after');
//    }
}
