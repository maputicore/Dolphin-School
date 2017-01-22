<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class StudentExampleTest extends \TestCase
{
    protected $credentials = [
        'email'    => 'iwgac1026@gmail.com',
        'password' => '12345678'
    ];

    /** @test */
    function it_should_display_title()
    {
        $this->visit('/')
             ->see('Laravel');
    }

    /** @test */
    function it_should_login_user()
    {
        $this->visit('/')
             ->type('hanachandev@gmail.com', 'email')
             ->type('12345678', 'password')
             ->press('Login')
             ->seeIsAuthenticated('student');
    }

    /** @test */
    function it_should_display_error()
    {
        $this->visit('/')
             ->see('Login')
             ->type('something@gmail.com', 'email')
             ->type('12345678', 'password')
             ->check('remember')
             ->press('Login')
             ->seePageIs('/login')
             ->see('These credentials do not match our records');
    }
}
