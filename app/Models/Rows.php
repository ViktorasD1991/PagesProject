<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Rows extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     *
     *
     */
    protected $fillable = ['name', 'order', 'page_id'];

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
    protected $table = 'rows';

    /**
     * Returns the columns that belong to this row
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function columns(): HasMany
    {
        return $this->hasMany(Columns::class, 'row_id', 'id');
    }
}
