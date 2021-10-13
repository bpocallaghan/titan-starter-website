<?php

namespace Tests\Unit\Models;

use App\Models\Banner;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BannerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_get_all_list()
    {
        $roles = Banner::factory()->count(5)->create();

        $rolesList = Banner::getAllList();

        $this->assertCount(5, $rolesList);
    }
}
