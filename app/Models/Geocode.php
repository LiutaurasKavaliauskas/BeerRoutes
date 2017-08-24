<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Model;

class Geocode extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'geocodes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'brewery_id',
        'latitude',
        'longitude',
        'accuracy',
    ];

    /**
     * Return asssigned brewery to geocode
     *
     * @return Model|null|static
     */
    public function getBrewery()
    {
        return $this->hasOne(Brewery::class, 'id', 'brewery_id')->first();
    }

    /**
     * Find nearest breweries for the point in given radius
     *
     * @param $latitude
     * @param $longitude
     * @param $radius
     * @return \Illuminate\Support\Collection
     * @throws Exception
     */
    public function getBreweriesInArea($latitude, $longitude, $radius)
    {
        latitudeIsValid($latitude);
        longitudeIsValid($longitude);

        $geocodes = Geocode::select('geocodes.*')
        ->selectRaw("(6371 * acos(cos(radians(?)) *
        cos(radians(latitude))
        * cos(radians(longitude) - radians(?)
        ) + sin(radians(?)) *
        sin(radians(latitude))))
        AS distance", [$latitude, $longitude, $latitude])
        ->havingRaw("distance < ?", [$radius])
        ->get();

        if ($geocodes->isEmpty()) {
            throw new Exception('No breweries in this area.');
        }

        return $geocodes;
    }
}
