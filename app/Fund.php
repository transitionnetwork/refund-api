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
        'status',
    ];

    protected $hidden = ['id', 'provider_id', 'created_at', 'updated_at', 'pivot'];

    /**
     * Returns the provider associated with the fund.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function provider()
    {
        return $this->belongsTo('App\Provider');
    }

    /**
     * Returns the regions associated with the fund.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function regions()
    {
        return $this->belongsToMany('App\Region');
    }

    /**
     * Returns the countries associated with the fund.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function countries()
    {
        return $this->belongsToMany('App\Country');
    }

    /**
     * Returns the locations associated with the fund.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function locations()
    {
        return $this->belongsToMany('App\Location');
    }

    /**
     * Returns the organisation types associated with the fund.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function organisation_types()
    {
        return $this->belongsToMany('App\OrganisationType');
    }

    /**
     * Returns the provision types associated with the fund.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function provision_types()
    {
        return $this->belongsToMany('App\ProvisionType');
    }

    /**
     * Checks to see if a specified provision type is associated with the fund.
     * @param $type
     * @return bool
     */
    public function hasProvisionType($type)
    {
        foreach ($this->provision_types as $provision_type)
        {
            if ($provision_type->name == $type)
            {
                return true;
            }
        }

        return false;
    }

    /**
     * Checks to see if a specified organisation type is associated with the fund.
     * @param $type
     * @return bool
     */
    public function hasOrganisationType($type)
    {
        foreach ($this->organisation_types as $organisation_type)
        {
            if ($organisation_type->name == $type)
            {
                return true;
            }
        }

        return false;
    }
}
