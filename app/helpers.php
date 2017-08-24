<?php

if (!function_exists ('isBetween')) {
    /**
     * Check if number is between given numbers
     *
     * @param $number
     * @param $from
     * @param $to
     * @return bool
     */
    function isBetween($number, $from, $to)
    {
        if ($number >= $from && $number <= $to) {
            return true;
        }

        return false;
    }
}
