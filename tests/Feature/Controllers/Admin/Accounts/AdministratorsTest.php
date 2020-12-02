<?php

namespace Tests\Feature\Controllers\Admin\Accounts;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdministratorsTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    protected $path = '/admin/accounts/administrators';

    protected $viewPath = 'admin.accounts.administrators.index';

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

    /** @test */
    public function list_items()
    {
        $this->signInAdmin();
        $user = User::find(1);

        $response = $this->get($this->path);

        $response->assertStatus(200);
        $response->assertViewHas('items');
        $response->assertSee($user->fullname);
        $response->assertSee($user->cellphone);
    }
}
