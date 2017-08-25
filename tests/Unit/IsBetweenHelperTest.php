<?php

namespace Tests\Unit;

use Tests\TestCase;

class IsBetweenHelperTest extends TestCase
{
    /**
     * @param $number
     * @param $from
     * @param $to
     *
     * @dataProvider dataProvider
     */
    public function testNumberIsBetweenNumbers($number, $from, $to)
    {
        $this->assertTrue(isBetween($number, $from, $to));
    }

    /**
     * @param $number
     * @param $from
     * @param $to
     *
     * @dataProvider dataProviderForFalseResults
     */
    public function testNumberIsNotBetweenNumber($number, $from, $to)
    {
        $this->assertFalse(isBetween($number, $from, $to));
    }

    public function dataProvider()
    {
        return [
            [
                10, 0, 15,
            ],
            [
                10, 10, 15,
            ],
            [
                10, 1, 10,
            ],
            [
                10, 10, 10
            ]
        ];
    }

    public function dataProviderForFalseResults()
    {
        return [
          [
              10, 11, 15
          ]
        ];
    }
}
