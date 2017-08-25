<?php

namespace Tests\Unit;

use Exception;
use Tests\TestCase;

class longitudeIsValidHelperTest extends TestCase
{
    /**
     * @param $longitude
     * @dataProvider dataProvider
     */
    public function testLongitudeIsValid($longitude)
    {
        $this->assertTrue(longitudeIsValid($longitude));
    }

    /**
     * @param $longitude
     * @dataProvider dataProviderNotValid
     */
    public function testLongitudeIsNotValid($longitude)
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Wrong coordinates');

        longitudeIsValid($longitude);
    }

    public function dataProvider()
    {
        return [
            [
                -180
            ],
            [
                0
            ],
            [
                180
            ]
        ];
    }

    public function dataProviderNotValid()
    {
        return [
            [
              -181
            ],
            [
                181
            ]
        ];
    }
}
