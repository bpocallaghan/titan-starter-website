<?php

namespace Tests\Feature\Controllers\Admin\Settings;

use App\Models\Navigation;
use Illuminate\Support\Str;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class NavigationOrderTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    protected $resourceName = 'navigation';

    protected $path = '/admin/settings/navigations/order';

    protected $viewPath = 'admin.settings.navigations';

    /** @test */
    public function user_can_view()
    {
        $this->signInAdmin();

        $this->get($this->path)
            ->assertStatus(200)
            ->assertSee(Str::plural($this->resourceName))
            ->assertViewIs("{$this->viewPath}.order");
    }

    /** @test */
    public function can_update_order()
    {
        $this->withoutExceptionHandling();
        $this->signInAdmin();

        $navigationA = Navigation::factory()->create();
        $navigationB = Navigation::factory()->create();

        $attributes = [
            'list' => json_encode([
                ['id' => $navigationA->id],
                ['id' => $navigationB->id],
            ])
        ];

        $response = $this->followingRedirects()->from($this->path)->post($this->path, $attributes);

        $navigationA->refresh();
        $navigationB->refresh();

        $this->assertEquals(1, $navigationA->list_order);
        $this->assertEquals(2, $navigationB->list_order);
    }
}
