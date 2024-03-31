<?php

namespace Tests\Browser;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTruncation;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class AuthTest extends DuskTestCase
{
    use DatabaseTruncation;

    public function setUp(): void
    {
        parent::setUp();
        app()->setLocale('en');
    }

    /**
     * Test account creation for different roles.
     */
    public function testAccountCreationForDifferentRoles()
    {
        $roles = ['Business', 'Standard', 'Private'];

        foreach ($roles as $roleName) {
            $role = Role::where('name', $roleName)->first();

            $this->browse(function (Browser $browser) use ($role, $roleName) {
                $browser->visit('/register')
                    ->type('name', $roleName . ' test User')
                    ->type('email', strtolower($roleName) . '@test.com')
                    ->type('password', '!Ab12345')
                    ->type('password_confirmation', '!Ab12345')
                    ->select('role_id', $role->id)
                    ->click('[dusk="dusk-register-button"]')
                    ->assertPathIs('/dashboard')
                    ->driver->manage()->deleteAllCookies();
            });

            $this->assertDatabaseHas('users', [
                'email' => strtolower($roleName) . '@test.com',
                'role_id' => $role->id,
            ]);
        }
    }

    /**
     * Test login functionality for different roles.
     */
    public function testLoginFunctionalityForDifferentRoles()
    {
        $roles = ['Business', 'Standard', 'Private'];

        foreach ($roles as $roleName) {
            $role = Role::where('name', $roleName)->first();
            $user = User::factory()->create([
                'email' => strtolower($roleName) . '@test.com',
                'password' => bcrypt('!Ab12345'),
                'role_id' => $role->id,
            ]);

            $this->browse(function (Browser $browser) use ($user, $roleName) {
                $browser->visit('/login')
                    ->type('email', $user->email)
                    ->type('password', '!Ab12345')
                    ->press('@dusk-login-button')
                    ->assertPathIs('/dashboard')
                    ->assertSee(__('texts.logged_in_' . strtolower($roleName)))
                    ->driver->manage()->deleteAllCookies();
            });
        }
    }
}
