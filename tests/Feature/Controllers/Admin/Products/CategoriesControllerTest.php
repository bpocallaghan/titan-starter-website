<?php

namespace Tests\Feature\Controllers\Admin\Products;

use Tests\TestCase;
use App\Models\ProductCategory;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoriesControllerTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    protected $table = 'product_categories';

    protected $resourceName = 'Product Category';

    protected $path = '/admin/shop/categories';

    protected $viewPath = 'admin.shop.categories';

    protected $model = ProductCategory::class;

    private function validParams($overrides = [])
    {
        return array_merge([
            'name'  => 'Example Category',
            'photo' => UploadedFile::fake()->image('image.jpg', 500, 500),
        ], $overrides);
    }

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

        // view create form
        $this->get("{$this->path}/create")
            ->assertStatus(200)
            ->assertSee($this->resourceName)
            ->assertViewIs("{$this->viewPath}.create_edit");

        // view home (to save the redirect url in session)
        $this->get($this->path);

        $attributes = $this->validParams();

        // submit form
        $this->followingRedirects()
            ->from("{$this->path}/create")
            ->post($this->path, $attributes)
            ->assertViewIs("{$this->viewPath}.index")
            ->assertSee($attributes['name'])
            ->assertSee(Str::plural($this->resourceName));

        $this->assertDatabaseHas($this->table, ['name' => $attributes['name']]);

        $item = ProductCategory::orderBy('created_at', 'DESC')->take(1)->get()->first();

        // Assert the file was stored...
        Storage::disk('public_web')->assertExists("images/{$item->image}");
    }

    /** @test */
    public function validate_on_create()
    {
        $this->signInAdmin();

        $this->get($this->path);

        $this->get("{$this->path}/create")->assertStatus(200)->assertSee($this->resourceName);

        $attributes = $this->model::factory()->raw([
            'name' => null,
        ]);

        $this->post($this->path, $attributes)->assertSessionHasErrors(['name']);
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
            ->assertSee($this->resourceName);

        $this->assertDatabaseHas($this->table, [
            'id'   => $resource->id,
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
