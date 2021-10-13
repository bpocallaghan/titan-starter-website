<?php

namespace Tests\Unit\Models;

use App\Models\Navigation;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class NavigationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_get_url()
    {
        $navigation = Navigation::factory()->make([
            'url' => '/example'
        ]);

        $this->assertEquals('/example', $navigation->url);
    }

    /** @test */
    public function can_get_parent_relationship()
    {
        $navigationParent = Navigation::factory()->create();
        $navigation = Navigation::factory()->create([
            'parent_id' => $navigationParent
        ]);

        $this->assertInstanceOf(Navigation::class, $navigation->parent);
        $this->assertEquals($navigationParent->id, $navigation->parent->id);
    }

    /** @test */
    public function can_get_url_parent_relationship()
    {
        $navigationParent = Navigation::factory()->create();
        $navigation = Navigation::factory()->create([
            'url_parent_id' => $navigationParent
        ]);

        $this->assertInstanceOf(Navigation::class, $navigation->urlParent);
        $this->assertEquals($navigationParent->id, $navigation->urlParent->id);
    }

    /** @test */
    public function can_update_url()
    {
        $navigation = Navigation::factory()->make([
            'slug' => 'slug',
        ]);

        $navigation->updateUrl();
        $this->assertEquals('/admin/slug', $navigation->url);
    }
}
