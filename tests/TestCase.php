<?php

namespace Tests;

use App\User;
use App\Models\Role;
use RolesTableSeeder;
use NavigationsTableSeeder;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected $loginPath = '/auth/login';

    /**
     * Seed the Database
     */
    public function setUpDatabase()
    {
        $this->seed();
    }

    private function seedRolesAndNavigation()
    {
        $this->seed(RolesTableSeeder::class);
        $this->seed(NavigationsTableSeeder::class);
    }

    /**
     * Sign user in
     * @param null $user
     * @return mixed|null
     */
    protected function signIn($user = null)
    {
        $user = $user ?: factory(User::class)->create();

        $this->actingAs($user);

        $user->update([
            'logged_in_at' => now()
        ]);

        return $user;
    }

    /**
     * Seed the roles and navigation tables
     * Create user and assign developer roles
     * Sign the user in
     * @return mixed|null
     */
    protected function signInAdmin()
    {
        $this->seedRolesAndNavigation();

        $user = factory(User::class)->states('admin')->create();

        $user = $this->signIn($user);

        return $user;
    }
}
