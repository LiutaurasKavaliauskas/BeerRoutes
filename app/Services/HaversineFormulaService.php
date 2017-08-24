<?php

namespace App\Services;

use Exception;

class HaversineFormulaService
{
    const EARTH_RADIUS = 6371;

    /**
     * Start point latitude
     *
     * @var
     */
    protected $latFrom;

    /**
     * Start point longitude
     *
     * @var
     */
    protected $lngFrom;

    /**
     * End point latitude
     *
     * @var
     */
    protected $latTo;

    /**
     * End point longitude
     *
     * @var
     */
    protected $lngTo;

    public function __construct()
    {
    }

    /**
     * Return start point latitude
     *
     * @return mixed
     */
    public function getLatitudeFrom()
    {
        return $this->latFrom;
    }

    /**
     * Set start point latitude
     *
     * @param $latFrom
     * @throws Exception
     */
    public function setLatitudeFrom($latFrom)
    {
        if (latitudeIsValid($latFrom)) {
            $this->latFrom = $latFrom;
        }
    }

    /**
     * Return start point longitude
     *
     * @return mixed
     */
    public function getLongitudeFrom()
    {
        return $this->lngFrom;
    }

    /**
     * Set start point longitude
     *
     * @param $lngFrom
     * @throws Exception
     */
    public function setLongitudeFrom($lngFrom)
    {
        if (longitudeIsValid($lngFrom)) {
            $this->lngFrom = $lngFrom;
        }
    }

    /**
     * Return end point latitude
     *
     * @return mixed
     */
    public function getLatitudeTo()
    {
        return $this->latTo;
    }

    /**
     * Set end point latitude
     *
     * @param $latTo
     * @throws Exception
     */
    public function setLatitudeTo($latTo)
    {
        if (latitudeIsValid($latTo)) {
            $this->latTo = $latTo;
        }
    }

    /**
     * Get end point longitude
     *
     * @return mixed
     */
    public function getLongitudeTo()
    {
        return $this->lngTo;
    }

    /**
     * Set end point longitude
     *
     * @param $lngTo
     * @throws Exception
     */
    public function setLongitudeTo($lngTo)
    {
        if (longitudeIsValid($lngTo)) {
            $this->lngTo = $lngTo;
        }
    }

    /**
     * Calculates the great-circle distance between two points, with
     * the Haversine formula.
     *
     * @return int
     */
    public function calculateDistance()
    {
        $latFrom = deg2rad($this->getLatitudeFrom());
        $longFrom = deg2rad($this->getLongitudeFrom());
        $latTo = deg2rad($this->getLatitudeTo());
        $longTo = deg2rad($this->getLongitudeTo());

        $latDelta = $latTo - $latFrom;
        $longDelta = $longTo - $longFrom;

        $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
                cos($latFrom) * cos($latTo) * pow(sin($longDelta / 2), 2)));

        return $angle * self::EARTH_RADIUS;
    }
}