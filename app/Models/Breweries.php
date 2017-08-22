<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Breweries extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'breweries';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'name',
        'address1',
        'address2',
        'city',
        'state',
        'code',
        'country',
        'phone',
        'website',
        'filepath',
        'descript',
        'add_user',
        'last_mod',
    ];
}
