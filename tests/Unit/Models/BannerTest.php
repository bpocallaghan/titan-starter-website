<?php

namespace Tests\Unit\Models;

use App\Models\Banner;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BannerTest extends TestCase
{
    /** @test */
    public function can_get_active_badge()
    {
        $banner = factory(Banner::class)->make([
            'name' => 'Banner',
        ]);

        $this->assertEquals("<span class='badge badge-success'>Active</span>",
            $banner->is_active_label);
    }
}
