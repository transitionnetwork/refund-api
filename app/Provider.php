<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
    protected $table = 'providers';

    protected $fillable = ['name'];

    protected $hidden = ['id', 'created_at', 'updated_at', 'pivot'];

    /**
     * Returns the funds associated with the provider.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function funds()
    {
        return $this->hasMany('App\Fund');
    }
}
