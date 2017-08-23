<?php

namespace Tests\Unit;

use Exception;
use Tests\TestCase;

class HaversineFormulaHelperTest extends TestCase
{
    public function testCalculatesCorrectDistance()
    {
        $haversineDistanceResult = getDistanceByHaversine(15, 15, 90, 90);

        $this->assertEquals(8339.6194983419045, $haversineDistanceResult);
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

        getDistanceByHaversine($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo);
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
