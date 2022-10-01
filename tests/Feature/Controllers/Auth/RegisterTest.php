<?php

namespace Tests\Feature\Controllers\Auth;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    protected function successfulRegistrationRoute()
    {
        return route('home');
    }

    protected function registerGetRoute()
    {
        return route('register');
    }

    protected function registerPostRoute()
    {
        return route('register');
    }

    protected function guestMiddlewareRoute()
    {
        return route('home');
    }

    /** @test */
    public function guest_can_view_register()
    {
        $response = $this->get($this->registerGetRoute());

        $response->assertSuccessful();
        $response->assertViewIs('auth.register');
    }

    /** @test */
    public function authenticated_user_cannot_view_register()
    {
        $user = User::factory()->make();

        $response = $this->actingAs($user)->get($this->registerGetRoute());

        $response->assertRedirect($this->guestMiddlewareRoute());
    }

    /** @test */
    public function user_can_register()
    {
        Event::fake();

        $response = $this->post($this->registerPostRoute(), [
            'firstname'             => 'John',
            'lastname'              => 'Doe',
            'cellphone'             => '123456789',
            'email'                 => 'john@example.com',
            'password'              => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertRedirect(route('home'));
        $this->assertCount(1, $users = User::all());
        $this->assertAuthenticatedAs($user = $users->first());
        $this->assertEquals('John Doe', $user->fullname);
        $this->assertEquals('john@example.com', $user->email);
        $this->assertTrue(Hash::check('password', $user->password));
        Event::assertDispatched(Registered::class, function ($e) use ($user) {
            return $e->user->id === $user->id;
        });
    }

    /** @test */
    public function user_cannot_register_without_name()
    {
        $response = $this->from($this->registerGetRoute())->post($this->registerPostRoute(), [
            'firstname'             => '',
            'lastname'              => '',
            'email'                 => 'john@example.com',
            'password'              => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->assertCount(0, User::all());
        $response->assertRedirect($this->registerGetRoute());
        $response->assertSessionHasErrors('firstname');
        $response->assertSessionHasErrors('lastname');
        $this->assertTrue(session()->hasOldInput('email'));
        $this->assertFalse(session()->hasOldInput('password'));
        $this->assertGuest();
    }

    /** @test */
    public function user_cannot_register_without_email()
    {
        $response = $this->from($this->registerGetRoute())->post($this->registerPostRoute(), [
            'firstname'             => 'John',
            'lastname'              => 'Doe',
            'email'                 => '',
            'password'              => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->assertCount(0, User::all());
        $response->assertRedirect($this->registerGetRoute());
        $response->assertSessionHasErrors('email');
        $this->assertTrue(session()->hasOldInput('firstname'));
        $this->assertTrue(session()->hasOldInput('lastname'));
        $this->assertFalse(session()->hasOldInput('password'));
        $this->assertGuest();
    }

    /** @test */
    public function user_cannot_register_with_invalid_email()
    {
        $response = $this->from($this->registerGetRoute())->post($this->registerPostRoute(), [
            'firstname'             => 'John',
            'lastname'              => 'Doe',
            'cellphone'             => '123456789',
            'email'                 => 'invalid-email',
            'password'              => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->assertCount(0, User::all());
        $response->assertRedirect($this->registerGetRoute());
        $response->assertSessionHasErrors('email');
        $this->assertTrue(session()->hasOldInput('firstname'));
        $this->assertTrue(session()->hasOldInput('lastname'));
        $this->assertTrue(session()->hasOldInput('email'));
        $this->assertFalse(session()->hasOldInput('password'));
        $this->assertGuest();
    }

    /** @test */
    public function user_cannot_register_with_used_email()
    {
        User::factory()->create([
            'email' => 'john@example.com',
        ]);

        $response = $this->from($this->registerGetRoute())->post($this->registerPostRoute(), [
            'firstname'             => 'John',
            'lastname'              => 'Doe',
            'email'                 => 'john@example.com',
            'password'              => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->assertCount(1, User::all());
        $response->assertRedirect($this->registerGetRoute());
        $response->assertSessionHasErrors('email');
        $this->assertTrue(session()->hasOldInput('firstname'));
        $this->assertTrue(session()->hasOldInput('lastname'));
        $this->assertTrue(session()->hasOldInput('email'));
        $this->assertFalse(session()->hasOldInput('password'));
        $this->assertGuest();
    }

    /** @test */
    public function user_cannot_register_without_password()
    {
        $response = $this->from($this->registerGetRoute())->post($this->registerPostRoute(), [
            'firstname'             => 'John',
            'lastname'              => 'Doe',
            'cellphone'             => '123456789',
            'email'                 => 'john@example.com',
            'password'              => '',
            'password_confirmation' => '',
        ]);

        $this->assertCount(0, User::all());
        $response->assertRedirect($this->registerGetRoute());
        $response->assertSessionHasErrors('password');
        $this->assertTrue(session()->hasOldInput('firstname'));
        $this->assertTrue(session()->hasOldInput('lastname'));
        $this->assertTrue(session()->hasOldInput('email'));
        $this->assertFalse(session()->hasOldInput('password'));
        $this->assertGuest();
    }

    /** @test */
    public function user_cannot_register_without_password_confirmation()
    {
        $response = $this->from($this->registerGetRoute())->post($this->registerPostRoute(), [
            'firstname'             => 'John',
            'lastname'              => 'Doe',
            'cellphone'             => '123456789',
            'email'                 => 'john@example.com',
            'password'              => 'password',
            'password_confirmation' => '',
        ]);

        $this->assertCount(0, User::all());
        $response->assertRedirect($this->registerGetRoute());
        $response->assertSessionHasErrors('password');
        $this->assertTrue(session()->hasOldInput('firstname'));
        $this->assertTrue(session()->hasOldInput('lastname'));
        $this->assertTrue(session()->hasOldInput('email'));
        $this->assertFalse(session()->hasOldInput('password'));
        $this->assertGuest();
    }

    /** @test */
    public function user_cannot_register_if_passwords_do_not_match()
    {
        $response = $this->from($this->registerGetRoute())->post($this->registerPostRoute(), [
            'firstname'             => 'John',
            'lastname'              => 'Doe',
            'cellphone'             => '123456789',
            'email'                 => 'john@example.com',
            'password'              => 'password',
            'password_confirmation' => 'password1',
        ]);

        $this->assertCount(0, User::all());
        $response->assertRedirect($this->registerGetRoute());
        $response->assertSessionHasErrors('password');
        $this->assertTrue(session()->hasOldInput('firstname'));
        $this->assertTrue(session()->hasOldInput('lastname'));
        $this->assertTrue(session()->hasOldInput('email'));
        $this->assertFalse(session()->hasOldInput('password'));
        $this->assertGuest();
    }
}
