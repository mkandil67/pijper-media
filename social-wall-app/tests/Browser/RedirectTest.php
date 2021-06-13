<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class RedirectTest extends DuskTestCase
{
    use DatabaseMigrations;
    /**
     * All these tests check whether a user is authenticated to view a page. If not, the user
     * will be redirected to the login page.
     */

    /** @test */
    public function only_logged_in_users_can_see_the_homepageTest()
    {
        $response = $this->get('/home')
            ->assertRedirect('login');
    }
    /** @test */
    public function only_logged_in_users_can_see_the_calendarTest()
    {
        $response = $this->get('/calendar')
            ->assertRedirect('login');
    }
    /** @test */
    public function only_logged_in_users_can_see_the_trendingpageTest()
    {
        $response = $this->get('/viral')
            ->assertRedirect('login');
    }
    /** @test */
    public function only_logged_in_users_can_see_the_myActivitypageTest()
    {
        $response = $this->get('/activity')
            ->assertRedirect('login');
    }
    /** @test  */
    public function authenticated_users_are_redirected_to_categories_tabTest()
    {
        $this->actingAs(User::factory()->create());
        $response = $this->get('/categories')
            ->assertOk();
    }
}
