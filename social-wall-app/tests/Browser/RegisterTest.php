<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;

class RegisterTest extends DuskTestCase
{
    /**
     * Creating a new user through register page
     *
     * @return void
     */
    public function test_register_user()
    {

        $this->browse(function (Browser $browser) {
            $browser->visit('/register')
                    ->type('name', 'test')
                    ->type('email', 'test@test.com')
                    ->type('password', 'testpassword1')
                    ->type('password_confirmation', 'testpassword1')
                    ->press('Register')
                    ->assertPathIs('/categories');
        });

        User::where('email', '=', 'test@test.com')->delete();
    }
}
