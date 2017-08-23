<?php

if (!function_exists ('isBetween')) {
    function isBetween($number, $from, $to)
    {
        if ($number >= $from && $number <= $to) {
            return true;
        }

        return false;
    }
}
