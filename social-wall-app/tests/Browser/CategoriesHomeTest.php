<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;

class CategoriesHomeTest extends DuskTestCase
{
    use DatabaseMigrations;

    /** @test */
    public function test_selecting_categories_on_home_page()
    {

        $this->browse(function ($browser) {
            $browser->visit('/register')
                    ->type('name', 'test')
                    ->type('email', 'test2@test.com')
                    ->type('password', 'testpassword1')
                    ->type('password_confirmation', 'testpassword1')
                    ->press('Register')
                    ->assertPathIs('/categories')
                    ->clickAtXPAth('/html/body/div/main/div/div/div/div/form/div/input[1]')
                    ->press('Submit')
                    ->assertPathIs('/home')
                    ->clickAtXPath('/html/body/div/div/nav/div/div/ul/li[2]/a')
                    ->clickAtXPath('/html/body/div/div/nav/div/div/ul/li[2]/div/form/div/input[4]')
                    ->clickAtXPath('/html/body/div/div/nav/div/div/ul/li[2]/div/form/div/div[2]/div/button')
                    ->assertPathIs('/home');
        });

    }
}
