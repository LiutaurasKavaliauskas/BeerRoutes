<?php

namespace Tests\Unit;

use Exception;
use Tests\TestCase;

class latitudeIsValidHelperTest extends TestCase
{
    /**
     * @param $latitude
     * @dataProvider dataProvider
     */
    public function testLatitudeIsValid($latitude)
    {
        $this->assertTrue(latitudeIsValid($latitude));
    }

    /**
     * @param $latitude
     * @dataProvider dataProviderNotValid
     */
    public function testLatitudeIsNotValid($latitude)
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Wrong coordinates');

        latitudeIsValid($latitude);
    }

    public function dataProvider()
    {
        return [
            [
                -90
            ],
            [
                0
            ],
            [
                90
            ]
        ];
    }

    public function dataProviderNotValid()
    {
        return [
            [
                -91
            ],
            [
                91
            ]
        ];
    }
}
