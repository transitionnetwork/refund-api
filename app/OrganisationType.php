<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrganisationType extends Model
{
    protected $table = 'organisation_types';

    protected $fillable = ['name'];

    /**
     * Returns the funds associated with the organisation type.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function funds()
    {
        return $this->belongsToMany('App\Fund');
    }
}
