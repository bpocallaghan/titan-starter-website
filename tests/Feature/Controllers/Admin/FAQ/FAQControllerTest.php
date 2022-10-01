<?php

namespace Tests\Feature\Controllers\Admin\FAQ;

use Tests\TestCase;
use App\Models\FAQ;
use App\Models\FAQCategory;
use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FAQControllerTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    protected $table = 'faqs';

    protected $resourceName = 'Faq';

    protected $path = '/admin/faqs';

    protected $viewPath = 'admin.faqs';

    protected $model = FAQ::class;

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
        $this->withoutExceptionHandling();
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
            ->assertSee($attributes['question'])
            ->assertSee(Str::plural($this->resourceName));

        $this->assertDatabaseHas($this->table, ['question' => $attributes['question']]);
    }

    /** @test */
    public function validate_on_create()
    {
        $this->signInAdmin();

        $this->get($this->path);

        $this->get("{$this->path}/create")->assertStatus(200)->assertSee($this->resourceName);

        $attributes = $this->model::factory()->raw([
            'question'    => null,
            'category_id' => null,
        ]);

        $this->post($this->path, $attributes)
            ->assertSessionHasErrors(['question'])
            ->assertSessionHasErrors(['category_id']);
    }

    /** @test */
    public function user_can_show()
    {
        $this->signInAdmin();

        $resource = $this->model::factory()->create();

        $this->get("{$this->path}/{$resource->id}")
            ->assertSee($resource->question)
            ->assertSee($resource->category->name)
            ->assertSee($this->resourceName);
    }

    /** @test */
    public function user_can_update()
    {
        $this->signInAdmin();

        $resource = $this->model::factory()->create();

        $this->get("{$this->path}/{$resource->id}/edit")->assertStatus(200);

        $resource->question = 'new-question';

        $this->get($this->path);

        $this->followingRedirects()
            ->put("{$this->path}/{$resource->id}", $resource->toArray())
            ->assertViewIs("{$this->viewPath}.index")
            ->assertSee($resource->question)
            ->assertSee(Str::plural($this->resourceName));

        $this->assertDatabaseHas($this->table, [
            'id'       => $resource->id,
            'question' => 'new-question'
        ]);
    }

    /** @test */
    public function validate_on_update()
    {
        $this->signInAdmin();

        $resource = $this->model::factory()->create();

        $this->get("{$this->path}/{$resource->id}/edit")->assertStatus(200);

        $resource->question = null;

        $this->put("{$this->path}/{$resource->id}", $resource->toArray())
            ->assertSessionHasErrors(['question']);
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
