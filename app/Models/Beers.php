<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Beers extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'beers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'brewery_id',
        'name',
        'cat_id',
        'style_id',
        'abv',
        'ibu',
        'srm',
        'upc',
        'filepath',
        'descript',
        'add_user',
        'last_mod',
    ];
}
