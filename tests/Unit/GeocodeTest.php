<?php

namespace Tests\Unit;

use App\Models\Geocode;
use Tests\TestCase;

class GeocodeTest extends TestCase
{
    protected $geocode;

    public function setUp()
    {
        $this->geocode = new Geocode([
            'id'         => 1,
            'brewery_id' => 1,
            'latitude'   => 100,
            'longitude'  => 100,
            'accuracy'   => 'Test',
        ]);
    }

    public function testGeocodeHasId()
    {
        $this->assertEquals(1, $this->geocode->id);
    }

    public function testGeocodeHasBreweryId()
    {
        $this->assertEquals(1, $this->geocode->brewery_id);
    }

    public function testGeocodeHasLatitude()
    {
        $this->assertEquals(100, $this->geocode->latitude);
    }

    public function testGeocodeHasLongitude()
    {
        $this->assertEquals(100, $this->geocode->longitude);
    }

    public function testGeocodeHasAccuracy()
    {
        $this->assertEquals('Test', $this->geocode->accuracy);
    }
}
