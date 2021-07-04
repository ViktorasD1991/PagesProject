<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Elements extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['data', 'type', 'column_id'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [];

    /**
     * The table associated with the Model
     *
     * @var string
     */
    protected $table = 'elements';
}
