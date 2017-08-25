<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class FindBeersCommandTest extends TestCase
{
    public function testFindsBeers()
    {
        Artisan::call('beers:find', [
            '--lat' => 51.355468,
            '--long' => 11.100790,
        ]);

        $this->assertNotNull(Artisan::output(), true);
    }

    public function testCommandNotRunsWithoutParameters()
    {
        Artisan::call('beers:find');

        $this->assertEquals("Not enough parameters\n", Artisan::output());
    }
}
