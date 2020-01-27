<?php

namespace Tests\Unit\Admin\Settings;

use App\Models\Role;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RoleTest extends TestCase
{
    /** @test */
    public function can_get_name_slug()
    {
        $role = factory(Role::class)->make([
            'name' => 'Role',
            'slug' => '/role',
        ]);

        $this->assertEquals('Role (/role)', $role->name_slug);
    }

    /** @test */
    public function can_get_icon_title()
    {
        $role = factory(Role::class)->make([
            'name' => 'Role',
            'icon' => 'smile',
        ]);

        $this->assertEquals('<i class="fa fa-smile"</i> Role', $role->icon_title);
    }

    ///** @test */
    //public function can_get_all_list()
    //{
    //    $roles = factory(Role::class, 5)->make();
    //
    //    $rolesList = Role::getAllLists();
    //
    //    $this->assertCount(5, $rolesList);
    //}
}
