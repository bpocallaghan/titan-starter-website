<?php

namespace Tests\Feature\Controllers\Admin\Products;

use App\Models\Product;
use Illuminate\Support\Str;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductsControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $table = 'products';

    protected $resourceName = 'product';

    protected $path = '/admin/shop/products';

    protected $viewPath = 'admin.shop.products';

    protected $model = Product::class;

    /**
     * @param array $overrides
     * @return array
     */
    private function validParams($overrides = [])
    {
        $attributes = $this->model::factory()->make()->toArray();

        return array_merge($attributes, $overrides);
    }

    /** @test */
    public function business_can_view()
    {
        $this->signInAdmin();

        $this->get("{$this->path}")
            ->assertStatus(200)
            ->assertSee('Products')
            ->assertViewIs("{$this->viewPath}.index")
            ->assertViewHas("items");
    }

    /** @test */
    public function business_can_create()
    {
        $this->signInAdmin();

        $attributes = $this->validParams([
            'features' => [1, 2]
        ]);

        // view create form
        $this->get("{$this->path}/create")
            ->assertStatus(200)
            ->assertSee($this->resourceName)
            ->assertViewIs("{$this->viewPath}.create_edit");

        // view home (to save the redirect url in session)
        $this->get($this->path);

        // submit form
        $response = $this->followingRedirects()
            ->from("{$this->path}/create")
            ->post($this->path, $attributes)
            ->assertSessionHasNoErrors()
            ->assertViewIs("{$this->viewPath}.index")
            ->assertSee(Str::plural($this->resourceName));

        $this->assertDatabaseHas($this->table, ['name' => $attributes['name']]);
        $this->assertDatabaseHas($this->table, ['amount' => $attributes['amount']]);
        $this->assertDatabaseHas($this->table, ['reference' => $attributes['reference']]);
    }

    /** @test */
    public function validate_on_create()
    {
        $this->signInAdmin();

        $this->get($this->path);
        $this->get("{$this->path}/create")->assertStatus(200)->assertSee($this->resourceName);

        $attributes = $this->validParams([
            'name' => null,
            'amount' => null,
            'category_id' => null,
            'features' => null
        ]);

        $this->post($this->path, $attributes)
            ->assertSessionHasErrors(['name'])
            ->assertSessionHasErrors(['amount'])
            ->assertSessionHasErrors(['category_id'])
            ->assertSessionHasErrors(['features']);
    }

    /** @test */
    public function user_can_update()
    {
        $this->signInAdmin();

        $resource = $this->model::factory()->create();

        $this->get("{$this->path}/{$resource->id}/edit")->assertOk();

        $attributes = $resource->toArray();
        $attributes['name'] = 'New Name';
        $attributes['features'] = [1,2,3];
        unset($attributes['category']);

        $this->get($this->path);

        $this->followingRedirects()
            ->put("{$this->path}/{$resource->id}", $attributes)
            ->assertViewIs("{$this->viewPath}.index")
            ->assertSee(Str::plural($this->resourceName));

        $this->assertDatabaseHas($this->table, [
            'id'   => $resource->id,
            'name' => 'New Name'
        ]);
    }

    /** @test */
    public function validate_on_update()
    {
        $this->signInAdmin();

        $resource = $this->model::factory()->create();

        $this->get("{$this->path}/{$resource->id}/edit")->assertOk();

        $resource->name = null;
        $resource->amount = null;
        $resource->category_id = null;

        $this->put("{$this->path}/{$resource->id}", $resource->toArray())
            ->assertSessionHasErrors(['name'])
            ->assertSessionHasErrors(['amount'])
            ->assertSessionHasErrors(['category_id']);
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
