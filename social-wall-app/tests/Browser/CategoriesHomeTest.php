<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;

class CategoriesHomeTest extends DuskTestCase
{

    /**
     * Test selecting cateogries after registering
     *
     * @return void
     */
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
                    ->click('#navbarDropdown')
                    ->click('#navbarSupportedContent > ul > li.nav-item.dropdown.show > div > form > div > input[type=checkbox]:nth-child(10)')
                    ->click('#navbarSupportedContent > ul > li.nav-item.dropdown.show > div > form > div > div.form-group.row.mb-0 > div > button')
                    ->assertPathIs('/home');
        });

        User::where('email', '=', 'test2@test.com')->delete();

    }
}
