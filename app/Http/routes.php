<?php

Route::group(['prefix' => 'v1'], function () {

    // Users

    // Funds
    Route::resource('funds', 'FundController', ['except' => ['create', 'edit']]);
    Route::resource('funds.countries', 'FundCountriesController', ['only' => ['index', 'show']]);

    // Providers
    Route::resource('providers', 'ProviderController', ['except' => ['create', 'edit']]);
    Route::resource('providers.funds', 'ProviderFundsController', ['only' => ['index', 'show']]);

    // Countries
    Route::resource('countries', 'CountryController', ['except' => ['create', 'edit']]);
    Route::resource('countries.funds', 'CountryFundsController', ['only' => ['index', 'show']]);

    // Locations

    // Regions

    // Organisation Types

    // Provision Types

});
