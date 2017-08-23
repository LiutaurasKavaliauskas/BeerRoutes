<?php
// TODO move to the class, services
if (!function_exists ('getDistanceByHaversine')) {
    /**
     * Calculates the great-circle distance between two points, with
     * the Haversine formula.
     *
     * @param $latFrom
     * @param $lngFrom
     * @param $latTo
     * @param $lngTo
     * @return double
     */
    function getDistanceByHaversine($latFrom, $lngFrom, $latTo, $lngTo)
    {
        $isLatFromValid = isBetween($latFrom, -90, 90);
        $isLngFromValid = isBetween($lngFrom, -180, 180);
        $isLatToValid = isBetween($latTo, -90, 90);
        $isLngToValid = isBetween($lngTo, -180, 180);

        if (!$isLatFromValid || !$isLngFromValid || !$isLatToValid || !$isLngToValid) {
            throw new Exception('Wrong coordinates');
        }

        $earthRadius = 6371;
        $latFrom = deg2rad($latFrom);
        $longFrom = deg2rad($lngFrom);
        $latTo = deg2rad($latTo);
        $longTo = deg2rad($lngTo);

        $latDelta = $latTo - $latFrom;
        $longDelta = $longTo - $longFrom;

        $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
                cos($latFrom) * cos($latTo) * pow(sin($longDelta / 2), 2)));

        return $angle * $earthRadius;

    }
}