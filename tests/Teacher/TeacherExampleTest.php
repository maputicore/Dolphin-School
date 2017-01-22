<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TeacherExampleTest extends \TeacherTestCase
{
    /** @test */
    function it_should_display_title()
    {
        $this->visit('/')
             ->see('Laravel');
    }
}
