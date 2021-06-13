<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;

class SearchTest extends DuskTestCase
{
    use DatabaseMigrations;

    /** @test */
    public function test_search_function_home_page()
    {

        $this->browse(function (Browser $browser) {
            $browser->visit('/register')
                    ->type('name', 'test')
                    ->type('email', 'test5@test.com')
                    ->type('password', 'testpassword1')
                    ->type('password_confirmation', 'testpassword1')
                    ->press('Register')
                    ->assertPathIs('/categories')
                    ->clickAtXPAth('/html/body/div/main/div/div/div/div/form/div/input[1]')
                    ->press('Submit')
                    ->assertPathIs('/home')
                    ->type('search', 'test')
                    ->clickAtXPath('/html/body/div/main/div/div/div[2]/div[1]/div[1]/form/div/span/button')
                    ->assertSee('The Search results for your query are :');
        });
    }
}
