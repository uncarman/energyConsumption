<?php

namespace Tests\Feature;

use App\Service\SamServer;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Container\Container;


class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        //$this->assert(true == true);
        $this->visit("/")->assertContent("");
    }
}
