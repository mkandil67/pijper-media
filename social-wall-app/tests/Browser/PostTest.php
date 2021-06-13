<?php

namespace Tests\Browser;

use App\Models\Post;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;

class PostTest extends DuskTestCase
{

    use DatabaseMigrations;

    /** @test */
    public function test_selecting_categories_on_home_page()
    {
        $this->browse(function ($browser) {

            $browser->visit('/register')
                    ->type('name', 'test')
                    ->type('email', 'test3@test.com')
                    ->type('password', 'testpassword1')
                    ->type('password_confirmation', 'testpassword1')
                    ->press('Register')
                    ->assertPathIs('/categories')
                    ->clickAtXPAth('/html/body/div/main/div/div/div/div/form/div/input[1]')
                    ->clickAtXPAth('/html/body/div/main/div/div/div/div/form/div/input[2]')
                    ->clickAtXPAth('/html/body/div/main/div/div/div/div/form/div/input[3]')
                    ->clickAtXPAth('/html/body/div/main/div/div/div/div/form/div/input[4]')
                    ->clickAtXPAth('/html/body/div/main/div/div/div/div/form/div/input[5]')
                    ->press('Submit') // User Registered.
                    ->assertPathIs('/home')
                    ->clickAtXPath('/html/body/div/main/div/div/div[2]/div[1]/div[2]/div/div[1]/div[3]/div/form/button') // Added post to activity list.
                    ->assertPathIs('/home')
                    ->click('#navbarSupportedContent > ul > li:nth-child(3) > a')
                    ->assertPathIs('/activity') // Post visible in list of new activities.
                    ->clickAtXPath('//html/body/div/div/nav/div/div/ul/li[5]/a')
                    ->clickAtXPath('/html/body/div/div/nav/div/div/ul/li[5]/div/a[2]') // Check out my activity page.
                    ->clickAtXPath('/html/body/div/main/div/div/div/div/div/div[2]/div[3]/form/button') // Remove post from my activity page.
                    ->assertPathIs('/my_activity'); // Page successfully reloaded and post has been removed from my activity list.
        });
    }

}
