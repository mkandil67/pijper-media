<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;

class CategoriesTest extends DuskTestCase
{

    /**
     * Test selecting cateogries after registering
     *
     * @return void
     */
    public function test_selecting_categories_after_register()
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
                    ->assertPathIs('/home');
        });

        User::where('email', '=', 'test1@test.com')->delete();

    }

    
}
