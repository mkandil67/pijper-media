<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;

class LoginTest extends DuskTestCase
{
    /**
     * Creating a new user and logging in through login page
     *
     * @return void
     */
    public function test_login_user()
    {
        $user = User::factory()->create([
            'email' => 'test@test.com',
        ]);

        $this->browse(function ($browser) use ($user) {
            $browser->visit('/login')
                    ->type('email', $user->email)
                    ->type('password', 'password')
                    ->press('Login')
                    ->assertPathIs('/home');

            $user->delete();
        });
    }
}
