<?php

namespace Tests\Unit\Traits;

use Tests\TestCase;
use App\Models\Banner;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ImageThumbTest extends TestCase
{
    /** @test */
    public function can_get_thumb()
    {
        $banner = Banner::factory()->make([
            'image' => 'image.jpg',
        ]);

        $this->assertEquals('image-tn.jpg', $banner->thumb);
    }

    /** @test */
    public function can_get_original_filename()
    {
        $banner = Banner::factory()->make([
            'image' => 'image.jpg',
        ]);

        $this->assertEquals('image-o.jpg', $banner->original_filename);
    }

    /** @test */
    public function can_get_extension()
    {
        $banner = Banner::factory()->make([
            'image' => 'image.jpg',
        ]);

        $this->assertEquals('.jpg', $banner->extension);
    }

    /** @test */
    public function can_get_image_thumb()
    {
        $banner = Banner::factory()->make([
            'image' => 'image.jpg',
        ]);

        $this->assertEquals('image-tn.jpg', $banner->image_thumb);
    }

    /** @test */
    public function can_get_image_original()
    {
        $banner = Banner::factory()->make([
            'image' => 'image.jpg',
        ]);

        $this->assertEquals('image-o.jpg', $banner->image_original);
    }

    /** @test */
    public function can_get_image_url()
    {
        $banner = Banner::factory()->make([
            'image' => 'image.jpg',
        ]);

        $this->assertEquals(config('app.url') . '/uploads/images/image.jpg', $banner->image_url);
    }

    /** @test */
    public function can_get_thumb_url()
    {
        $banner = Banner::factory()->make([
            'image' => 'image.jpg',
        ]);

        $this->assertEquals(config('app.url') . '/uploads/images/image-tn.jpg', $banner->thumb_url);
    }

    /** @test */
    public function can_get_original_url()
    {
        $banner = Banner::factory()->make([
            'image' => 'image.jpg',
        ]);

        $this->assertEquals(config('app.url') . '/uploads/images/image-o.jpg', $banner->original_url);
    }
}
