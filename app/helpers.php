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

if (!function_exists ('longitudeIsValid')) {
    /**
     * Check if longitude is valid
     *
     * @param $longitude
     * @return bool
     * @throws Exception
     */
    function longitudeIsValid($longitude)
    {
        if (isBetween($longitude, -180, 180)) {
            return true;
        }

        throw new Exception('Wrong coordinates');
    }
}

if (!function_exists ('latitudeIsValid')) {
    /**
     * Check if latitude is valid
     *
     * @param $latitude
     * @return bool
     * @throws Exception
     */
    function latitudeIsValid($latitude)
    {
        if (isBetween($latitude, -90, 90)) {
            return true;
        }

        throw new Exception('Wrong coordinates');
    }
}