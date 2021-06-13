<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;

class LoginTest extends DuskTestCase
{
    use DatabaseMigrations;
    /** @test */
    public function test_login_user()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/register')
                ->type('name', 'test')
                ->type('email', 'test1@test.com')
                ->type('password', 'testpassword1')
                ->type('password_confirmation', 'testpassword1')
                ->press('Register')
                ->assertPathIs('/categories')
                ->clickAtXPAth('/html/body/div/main/div/div/div/div/form/div/input[1]')
                ->press('Submit')
                ->assertPathIs('/home')
                ->clickAtXPath('/html/body/div/div/nav/div/div/ul/li[6]/a')
                ->clickAtXPath('/html/body/div/div/nav/div/div/ul/li[6]/div/a[3]')
                ->visit('/login')
                ->type('email', 'test1@test.com')
                ->type('password', 'testpassword1')
                ->press('Login');

        });
    }
}
