<?php

namespace Tests\Feature\Controllers\Admin\Products;

use Tests\TestCase;
use Illuminate\Support\Str;
use App\Models\ProductStatus;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StatusesControllerTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    protected $table = 'product_statuses';

    protected $resourceName = 'Product Status';

    protected $path = '/admin/shop/status';

    protected $viewPath = 'admin.shop.statuses';

    protected $model = ProductStatus::class;

    /** @test */
    public function guests_cannot_access_resource_actions()
    {
        $resource = $this->model::factory()->create();

        // list
        $this->get($this->path)->assertRedirect($this->loginPath);
        // create
        $this->get("{$this->path}/create")->assertRedirect($this->loginPath);
        // store
        $this->post($this->path, $resource->toArray())->assertRedirect($this->loginPath);
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
        $this->withoutExceptionHandling();
        $this->signInAdmin();

        $this->get($this->path)
            ->assertStatus(200)
            ->assertSee(Str::plural($this->resourceName))
            ->assertViewIs("{$this->viewPath}.index");
    }

    /** @test */
    public function user_can_create()
    {
        //$this->withoutExceptionHandling();
        $this->signInAdmin();

        // view create form
        $this->get("{$this->path}/create")
            ->assertStatus(200)
            ->assertSee($this->resourceName)
            ->assertViewIs("{$this->viewPath}.create_edit");

        // view home (to save the redirect url in session)
        $this->get($this->path);

        // create and save category
        $attributes = $this->model::factory()->make()->toArray();

        // submit form
        $this->followingRedirects()
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

        $attributes = $this->model::factory()->raw([
            'name'    => null,
            'category' => null,
        ]);

        $this->post($this->path, $attributes)
            ->assertSessionHasErrors(['name'])
            ->assertSessionHasErrors(['category']);
    }

    /** @test */
    public function user_can_update()
    {
        $this->signInAdmin();

        $resource = $this->model::factory()->create();

        $this->get("{$this->path}/{$resource->id}/edit")->assertStatus(200);

        $resource->name = 'new-name';

        $this->get($this->path);

        $this->followingRedirects()
            ->put("{$this->path}/{$resource->id}", $resource->toArray())
            ->assertViewIs("{$this->viewPath}.index")
            ->assertSee($resource->name)
            ->assertSee(Str::plural($this->resourceName));

        $this->assertDatabaseHas($this->table, [
            'id'       => $resource->id,
            'name' => 'new-name'
        ]);
    }

    /** @test */
    public function validate_on_update()
    {
        $this->signInAdmin();

        $resource = $this->model::factory()->create();

        $this->get("{$this->path}/{$resource->id}/edit")->assertStatus(200);

        $resource->name = null;

        $this->put("{$this->path}/{$resource->id}", $resource->toArray())
            ->assertSessionHasErrors(['name']);
    }

    /** @test */
    public function destroy()
    {
        $this->signInAdmin();

        $resource = $this->model::factory()->create();

        $this->delete("{$this->path}/{$resource->id}", ['_id' => $resource->id]);

        $this->assertSoftDeleted($this->table, ['id' => $resource->id]);
    }
}
