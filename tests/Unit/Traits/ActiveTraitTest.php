<?php

namespace Tests\Unit\Traits;

use App\Models\Banner;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ActiveTraitTest extends TestCase
{
    /** @test */
    public function can_get_active_badge()
    {
        $banner = Banner::factory()->make([
            'active_from' => now()->subWeek(),
            'active_to'   => now()->addWeek(),
        ]);

        $this->assertEquals(
            "<span class='badge badge-success'>Active</span>",
            $banner->date_badge
        );
    }

    /** @test */
    public function can_get_active_badge_with_no_active_to_date()
    {
        $banner = Banner::factory()->make([
            'active_from' => now()->subWeek(),
            'active_to'   => null,
        ]);

        $this->assertEquals(
            "<span class='badge badge-success'>Active</span>",
            $banner->date_badge
        );
    }

    /** @test */
    public function can_get_not_active_badge()
    {
        $banner = Banner::factory()->make([
            'active_from' => now()->addWeek(),
            'active_to'   => now()->addWeeks(2),
        ]);

        $this->assertEquals(
            "<span class='badge badge-warning'>Not Active</span>",
            $banner->date_badge
        );
    }

    /** @test */
    public function can_get_expired_badge()
    {
        $banner = Banner::factory()->make([
            'active_from' => now()->subWeek(),
            'active_to'   => now()->subDay(),
        ]);

        $this->assertEquals(
            "<span class='badge badge-danger'>Expired</span>",
            $banner->date_badge
        );
    }
}
