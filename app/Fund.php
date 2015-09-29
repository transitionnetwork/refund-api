<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fund extends Model
{
    protected $table = 'funds';

    protected $fillable = [
        'provider_id',
        'name',
        'website',
        'investment_term',
        'loans_rate',
        'min_size',
        'max_size',
        'focus',
        'status'
    ];

    /**
     * Returns the provider associated with the fund
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function provider()
    {
        return $this->hasOne('App\Provider');
    }

    /**
     * Returns the regions associated with the fund
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function regions()
    {
        return $this->belongsToMany('App\Region');
    }

    /**
     * Returns the countries associated with the fund
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function countries()
    {
        return $this->belongsToMany('App\Country');
    }

    /**
     * Returns the locations associated with the fund
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function locations()
    {
        return $this->belongsToMany('App\Location');
    }

    /**
     * Returns the organisation types associated with the fund
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function organisation_types()
    {
        return $this->belongsToMany('App\OrganisationType');
    }

    /**
     * Returns the provision types associated with the fund
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function provision_types()
    {
        return $this->belongsToMany('App\ProvisionType');
    }
}