<?php

namespace Tests\Unit;

use App\Services\HaversineFormulaService;
use Exception;
use Tests\TestCase;

class HaversineFormulaServiceTest extends TestCase
{
    protected $service;

    public function setUp()
    {
        $this->service = new HaversineFormulaService();
    }

    public function testServiceSetsUpLatitudeFromCorrectly()
    {
        $this->service->setLatitudeFrom(10);
        $this->assertEquals(10, $this->service->getLatitudeFrom());
    }

    public function testServiceSetsUpLongitudeFromCorrectly()
    {
        $this->service->setLongitudeFrom(10);
        $this->assertEquals(10, $this->service->getLongitudeFrom());
    }

    public function testCalculatesCorrectDistance()
    {
        $this->service->setLatitudeFrom(15);
        $this->service->setLongitudeFrom(15);
        $this->service->setLatitudeTo(90);
        $this->service->setLongitudeTo(90);

        $this->assertEquals(8339.6194983419045, $this->service->calculateDistance());
    }

    /**
     * @param $latitudeFrom
     * @param $longitudeFrom
     * @param $latitudeTo
     * @param $longitudeTo
     *
     * @dataProvider dataProvider
     */
    public function testResultIfGivenNumberIsNegative($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo)
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Wrong coordinates');

        $this->service->setLatitudeFrom($latitudeFrom);
        $this->service->setLongitudeFrom($longitudeFrom);
        $this->service->setLatitudeTo($latitudeTo);
        $this->service->setLongitudeTo($longitudeTo);

        $this->service->calculateDistance();
    }

    public function dataProvider()
    {
        return [
            [
                -91, 10, 10, 10
            ],
            [
                10, -181, 10, 10
            ],
            [
                10, 10, -91, 10
            ],
            [
                10, 10, 10, -181
            ],
        ];
    }
}
