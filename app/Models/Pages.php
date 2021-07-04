<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pages extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name'];

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
    protected $table = 'pages';

    /**
     * Returns the rows that belong to this page
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function rows(): HasMany
    {
        return $this->hasMany(Rows::class, 'page_id', 'id');
    }
}
