<?php

namespace Tests\Feature\Controllers\Admin\Accounts;

use App\Models\User;
use Illuminate\Support\Str;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ClientsTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    protected $table = 'users';

    protected $resourceName = 'client';

    protected $path = '/admin/accounts/clients';

    protected $viewPath = 'admin.accounts.clients';

    private function validParams($overrides = [])
    {
        return array_merge([
            'firstname'             => 'Example',
            'lastname'              => 'User',
            'cellphone'             => '123456789',
            'email'                 => 'user@example.com',
            'password'              => 'password',
            'password_confirmation' => 'password',
            'roles'                 => [1],
        ], $overrides);
    }

    /** @test */
    public function guest_cannot_view()
    {
        $this->get($this->path)->assertRedirect($this->loginPath);
    }

    /** @test */
    public function user_can_view()
    {
        $this->signInAdmin();

        $this->get($this->path)
            ->assertStatus(200)
            ->assertSee(Str::plural($this->resourceName))
            ->assertViewIs("{$this->viewPath}.index");
    }

    /** @test */
    public function user_can_create()
    {
        $this->signInAdmin();

        // view create form
        $this->get("{$this->path}/create")
            ->assertStatus(200)
            ->assertSee($this->resourceName)
            ->assertViewIs("{$this->viewPath}.create_edit");

        // view home (to save the redirect url in session)
        $this->get($this->path);

        $attributes = $this->validParams();

        // submit form
        $response = $this->followingRedirects()
            ->from("{$this->path}/create")
            ->post($this->path, $attributes)
            ->assertViewIs("{$this->viewPath}.index")
            ->assertSee($attributes['firstname'])
            ->assertSee(Str::plural($this->resourceName));

        $this->assertDatabaseHas($this->table, ['firstname' => $attributes['firstname']]);
    }

    /** @test */
    public function validate_on_create()
    {
        $this->signInAdmin();

        $this->get($this->path);

        $this->get("{$this->path}/create")->assertStatus(200)->assertSee($this->resourceName);

        $attributes = $this->validParams([
            'firstname' => null,
            'roles'     => null,
        ]);

        $this->post($this->path, $attributes)
            ->assertSessionHasErrors(['firstname'])
            ->assertSessionHasErrors(['roles']);
    }

    /** @test */
    public function user_can_update()
    {
        $this->withoutExceptionHandling();
        $this->signInAdmin();

        $resource = User::factory()->create();

        $this->get("{$this->path}/{$resource->id}/edit")->assertStatus(200);

        $attributes = $this->validParams([
            'firstname' => 'New Firstname'
        ]);

        $this->get($this->path);

        $this->followingRedirects()
            ->put("{$this->path}/{$resource->id}", $attributes)
            ->assertViewIs("{$this->viewPath}.index")
            ->assertSee($attributes['firstname'])
            ->assertSee(Str::plural($this->resourceName));

        $this->assertDatabaseHas($this->table, [
            'id'   => $resource->id,
            'firstname' => 'New Firstname'
        ]);
    }

    /** @test */
    public function validate_on_update()
    {
        $this->signInAdmin();

        $resource = User::factory()->create();

        $this->get("{$this->path}/{$resource->id}/edit")->assertStatus(200);

        $attributes = $this->validParams([
            'firstname' => null,
            'roles'     => null,
        ]);

        $this->put("{$this->path}/{$resource->id}", $attributes)
            ->assertSessionHasErrors(['firstname'])
            ->assertSessionHasErrors(['roles']);
    }

    /** @test */
    public function destroy()
    {
        $this->signInAdmin();

        $resource = User::factory()->create();

        $this->delete("{$this->path}/{$resource->id}", ['_id' => $resource->id]);

        $this->assertSoftDeleted($this->table, ['id' => $resource->id]);
    }
}
