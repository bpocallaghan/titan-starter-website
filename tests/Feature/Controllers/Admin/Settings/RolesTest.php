<?php

namespace Tests\Feature\Controllers\Admin\Settings;

use Tests\TestCase;
use App\Models\Role;
use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RolesTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    protected $table = 'roles';

    protected $resourceName = 'role';

    protected $path = '/admin/settings/roles';

    protected $viewPath = 'admin.settings.roles';

    /** @test */
    public function guests_cannot_access_resource_actions()
    {
        $resource = Role::factory()->create();

        // list
        $this->get($this->path)->assertRedirect($this->loginPath);
        // create
        $this->get("{$this->path}/create")->assertRedirect($this->loginPath);
        // store
        $this->post($this->path, $resource->toArray())->assertRedirect($this->loginPath);
        // show
        $this->get("{$this->path}/{$resource->id}")->assertRedirect($this->loginPath);
        // edit
        $this->get("{$this->path}/{$resource->id}/edit")->assertRedirect($this->loginPath);
        // update
        $this->put("{$this->path}/{$resource->id}", $resource->toArray())
            ->assertRedirect($this->loginPath);
        // delete
        $this->delete("{$this->path}/{$resource->id}")->assertRedirect($this->loginPath);
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

        $attributes = Role::factory()->raw();

        // view create form
        $this->get("{$this->path}/create")
            ->assertStatus(200)
            ->assertSee($this->resourceName)
            ->assertViewIs("{$this->viewPath}.create_edit");

        // view home (to save the redirect url in session)
        $this->get($this->path);

        // submit form
        $this->followingRedirects()
            ->from("{$this->path}/create")
            ->post($this->path, $attributes)
            ->assertViewIs("{$this->viewPath}.index")
            ->assertSee($attributes['name'])
            ->assertSee($attributes['keyword'])
            ->assertSee(Str::plural($this->resourceName));

        $this->assertDatabaseHas($this->table, ['name' => $attributes['name']]);
    }

    /** @test */
    public function validate_on_create()
    {
        $this->signInAdmin();

        $this->get($this->path);

        $this->get("{$this->path}/create")->assertStatus(200)->assertSee($this->resourceName);

        $attributes = Role::factory()->raw([
            'icon'    => null,
            'slug'    => null,
            'name'    => null,
            'keyword' => null
        ]);

        $this->post($this->path, $attributes)
            ->assertSessionHasErrors(['name'])
            ->assertSessionHasErrors(['slug'])
            ->assertSessionHasErrors(['keyword']);
    }

    /** @test */
    public function user_can_show()
    {
        $this->signInAdmin();

        $resource = Role::factory()->create();

        $this->get("{$this->path}/{$resource->id}")
            ->assertSee($resource->name)
            ->assertSee($resource->slug)
            ->assertSee($this->resourceName);
    }

    /** @test */
    public function user_can_update()
    {
        $this->signInAdmin();

        $resource = Role::factory()->create();

        $this->get("{$this->path}/{$resource->id}/edit")->assertStatus(200);

        $resource->name = 'new-name';

        $this->get($this->path);

        $this->followingRedirects()
            ->put("{$this->path}/{$resource->id}", $resource->toArray())
            ->assertViewIs("{$this->viewPath}.index")
            ->assertSee($resource->name)
            ->assertSee(Str::plural($this->resourceName));

        $this->assertDatabaseHas($this->table, [
            'id'   => $resource->id,
            'name' => 'new-name'
        ]);
    }

    /** @test */
    public function validate_on_update()
    {
        $this->signInAdmin();

        $resource = Role::factory()->create();

        $this->get("{$this->path}/{$resource->id}/edit")->assertStatus(200);

        $resource->slug = null;
        $resource->name = null;
        $resource->keyword = null;

        $this->put("{$this->path}/{$resource->id}", $resource->toArray())
            //->assertSessionHasErrors(['icon'])
            ->assertSessionHasErrors(['name'])
            ->assertSessionHasErrors(['slug'])
            ->assertSessionHasErrors(['keyword']);
    }

    /** @test */
    public function destroy()
    {
        $this->signInAdmin();

        $resource = Role::factory()->create();

        $this->delete("{$this->path}/{$resource->id}", ['_id' => $resource->id]);

        $this->assertSoftDeleted($this->table, ['id' => $resource->id]);
    }
}
