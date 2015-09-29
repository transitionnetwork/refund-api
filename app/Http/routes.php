<?php

Route::group(['prefix' => 'v1'], function () {

    // Users

    // Funds
    Route::resource('funds', 'FundController');
    Route::resource('funds.countries', 'FundCountriesController');

    // Providers
    Route::resource('providers', 'ProviderController');

    // Countries

    // Locations

    // Regions

    // Organisation Types

    // Provision Types

});
