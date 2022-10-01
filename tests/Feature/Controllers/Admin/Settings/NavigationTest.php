<?php

namespace Tests\Feature\Controllers\Admin\Settings;

use Tests\TestCase;
use App\Models\Navigation;
use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class NavigationTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    protected $table = 'navigations';

    protected $resourceName = 'navigation';

    protected $path = '/admin/settings/navigations';

    protected $viewPath = 'admin.settings.navigations';

    /** @test */
    public function guests_cannot_access_resource_actions()
    {
        $resource = Navigation::factory()->create();

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
        $this->withoutExceptionHandling();
        $this->signInAdmin();

        $attributes = Navigation::factory()->raw();
        $attributes['roles'] = [1, 2];

        // view create form
        $this->get("{$this->path}/create")
            ->assertStatus(200)
            ->assertSee($this->resourceName)
            ->assertViewIs("{$this->viewPath}.create_edit");

        // view home (to save the redirect url in session)
        $this->get($this->path);

        // submit form
        $xx = $this->followingRedirects()
            ->from("{$this->path}/create")
            ->post($this->path, $attributes)
            ->assertViewIs("{$this->viewPath}.index")
            ->assertSee($attributes['name'])
            ->assertSee(Str::plural($this->resourceName));

        $this->assertDatabaseHas($this->table, ['name' => $attributes['name']]);
    }

    /** @test */
    public function validate_on_create()
    {
        $this->signInAdmin();

        $this->get($this->path);

        $this->get("{$this->path}/create")->assertStatus(200)->assertSee($this->resourceName);

        $attributes = Navigation::factory()->raw([
            'name'        => null,
            'description' => null
        ]);

        $this->post($this->path, $attributes)
            ->assertSessionHasErrors(['name'])
            ->assertSessionHasErrors(['description']);
    }

    /** @test */
    public function user_can_show()
    {
        $this->signInAdmin();

        $resource = Navigation::factory()->create();

        $this->get("{$this->path}/{$resource->id}")
            ->assertSee($resource->name)
            ->assertSee($resource->description)
            ->assertSee($this->resourceName);
    }

    /** @test */
    public function user_can_update()
    {
        $this->withoutExceptionHandling();
        $this->signInAdmin();

        $resource = Navigation::factory()->create();

        $this->get("{$this->path}/{$resource->id}/edit")->assertStatus(200);

        $resource->name = 'new-name';

        $attributes = $resource->toArray();
        $attributes['roles'] = [1, 2];

        $this->get($this->path);

        $this->followingRedirects()
            ->put("{$this->path}/{$resource->id}", $attributes)
            ->assertViewIs("{$this->viewPath}.index")
            ->assertSee($attributes['name'])
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

        $resource = Navigation::factory()->create();

        $this->get("{$this->path}/{$resource->id}/edit")->assertStatus(200);

        $resource->name = null;
        $resource->description = null;

        $this->put("{$this->path}/{$resource->id}", $resource->toArray())
            ->assertSessionHasErrors(['name'])
            ->assertSessionHasErrors(['description']);
    }

    /** @test */
    public function destroy()
    {
        $this->signInAdmin();

        $resource = Navigation::factory()->create();

        $this->delete("{$this->path}/{$resource->id}", ['_id' => $resource->id]);

        $this->assertSoftDeleted($this->table, ['id' => $resource->id]);
    }
}
