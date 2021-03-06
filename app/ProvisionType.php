<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProvisionType extends Model
{
    protected $table = 'provision_types';

    protected $fillable = ['name'];

    protected $hidden = ['id', 'created_at', 'updated_at', 'pivot'];

    /**
     * Returns the funds associated with the provision type.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function funds()
    {
        return $this->belongsToMany('App\Fund');
    }
}
