<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Style extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'styles';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'cat_id',
        'style_name',
        'last_mod',
    ];
}
