<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $table = 'countries';

    protected $fillable = ['name'];

    /**
     * Returns the funds associated with the country.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function funds()
    {
        return $this->belongsToMany('App\Fund');
    }
}
