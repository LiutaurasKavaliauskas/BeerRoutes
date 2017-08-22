<?php

if (!function_exists ('getDistanceByHaversine')) {
    /**
     * Calculates the great-circle distance between two points, with
     * the Haversine formula.
     *
     * @param $latitudeFrom
     * @param $longitudeFrom
     * @param $latitudeTo
     * @param $longitudeTo
     * @param int $earthRadius
     * @return double
     */
    function getDistanceByHaversine($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $earthRadius = 6371000)
    {
        $latFrom = deg2rad($latitudeFrom);
        $longFrom = deg2rad($longitudeFrom);
        $latTo = deg2rad($latitudeTo);
        $longTo = deg2rad($longitudeTo);

        $latDelta = $latTo - $latFrom;
        $longDelta = $longTo - $longFrom;

        $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
                cos($latFrom) * cos($latTo) * pow(sin($longDelta / 2), 2)));

        return $angle * $earthRadius;
    }
}