<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;

class RegisterTest extends DuskTestCase
{
    use DatabaseMigrations;

    /** @test */
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

    }
    /** @test test if the credentials are correct*/
    public function test_correct_credentials_for_registering()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/register')
                ->type('name', 'test')
                ->type('email', 'test@test.com')
                ->type('password', '12345') // password is to short
                ->type('password_confirmation', '12345')
                ->press('Register')
                ->assertSee('The password must be at least 8 characters.')
                ->type('password', '12345678')
                ->type('password_confirmation', '12345') // passwords do not match
                ->press('Register')
                ->assertSee('The password confirmation does not match.');
        });
    }
    /** @test check there cannot be duplicate emails whilst registering*/
    public function test_no_duplicates_whilst_registering()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/register')
                ->type('name', 'test')
                ->type('email', 'test@test.com')
                ->type('password', 'testpassword1')
                ->type('password_confirmation', 'testpassword1')
                ->press('Register')
                ->assertPathIs('/categories')
                ->clickAtXPath('/html/body/div/div/nav/div/div/ul/li[5]/a')
                ->clickAtXPath('/html/body/div/div/nav/div/div/ul/li[5]/div/a[3]')
                ->visit('/register')
                ->type('name', 'test')
                ->type('email', 'test@test.com')
                ->type('password', 'testpassword1')
                ->type('password_confirmation', 'testpassword1')
                ->press('Register')
                ->assertSee('The email has already been taken.');
        });
    }

}
