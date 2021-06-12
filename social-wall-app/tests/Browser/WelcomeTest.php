<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class WelcomeTest extends DuskTestCase
{
    /**
     * Welcome page visit
     *
     * @return void
     */
    public function test_welcome_page()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->assertPathIs('/');
        });
    }
}
