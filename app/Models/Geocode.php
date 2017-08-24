<?php

namespace App\Models;

use App\Services\HaversineFormulaService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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

    public function getBreweriesInArea($latitude, $longitude, $radius)
    {
        return Geocode::select('geocodes.*')
        ->selectRaw("(6371 * acos(cos(radians(?)) *
        cos(radians(latitude))
        * cos(radians(longitude) - radians(?)
        ) + sin(radians(?)) *
        sin(radians(latitude))))
                                AS distance", [$latitude, $longitude, $latitude]
        )
        ->havingRaw("distance < ?", [$radius])
        ->get();
    }
}
