<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Columns extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'order', 'row_id'];

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
    protected $table = 'columns';

    /**
     * Returns the elements that belong to a column
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function elements(): HasMany
    {
        return $this->hasMany(Elements::class, 'column_id', 'id');
    }
}
