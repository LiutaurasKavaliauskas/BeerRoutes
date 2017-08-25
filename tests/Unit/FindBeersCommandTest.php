<?php

namespace Tests\Unit;

use Exception;
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

    /**
     * @param $longitude
     * @param $latitude
     * @dataProvider dataProviderWrongCoordinates
     */
    public function testCommandNotRunsWithWrongCoordinates($longitude, $latitude)
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Wrong coordinates');

        Artisan::call('beers:find', [
            '--lat' => $longitude,
            '--long' => $latitude,
        ]);
    }

    /**
     * @param $longitude
     * @param $latitude
     * @dataProvider dataProviderNoBreweriesAreas
     */
    public function testCommandStopsIfNoBreweriesInGiveArea($longitude, $latitude)
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage("No breweries in this area.");

        Artisan::call('beers:find', [
            '--lat' => $longitude,
            '--long' => $latitude,
        ]);
    }

    public function dataProviderWrongCoordinates()
    {
        return [
            [
                -181, 10
            ],
            [
                181, 10
            ],
            [
                10, -91
            ],
            [
                10, 91
            ]
        ];
    }

    public function dataProviderNoBreweriesAreas()
    {
        return [
            [
                50, 100
            ],
            [
                50, 150
            ]
        ];
    }
}
