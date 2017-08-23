<?php

namespace App\Models;

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
}
