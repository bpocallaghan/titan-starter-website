<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected $loginPath = '/auth/login';

    /**
     * Seed the Database
     */
    protected function setUpDatabase(): void
    {
        $this->seed();
    }

    private function seedRolesAndNavigation(): void
    {
        $this->seed(RolesTableSeeder::class);
        $this->seed(NavigationsTableSeeder::class);
    }

    protected function seedPages(): void
    {
        $this->seed(PagesTableSeeder::class);
    }

    /**
     * Sign user in
     * @param null $user
     * @return mixed|null
     */
    protected function signIn($user = null)
    {
        $user = $user ?: User::factory()->create();

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

        $user = User::factory()->admin()->create();

        $user = $this->signIn($user);

        return $user;
    }
}
