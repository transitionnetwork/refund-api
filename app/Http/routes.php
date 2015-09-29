<?php

Route::group(['prefix' => 'v1'], function () {

    // Users

    // Funds
    Route::resource('funds', 'FundController', ['except' => ['create', 'edit']]);
    Route::resource('funds.countries', 'FundCountriesController', ['only' => ['index', 'show']]);
    Route::resource('funds.locations', 'FundLocationsController', ['only' => ['index', 'show']]);
    Route::resource('funds.regions', 'FundRegionsController', ['only' => ['index', 'show']]);
    Route::resource('funds.provision-types', 'FundProvisionTypesController', ['only' => ['index', 'show']]);
    Route::resource('funds.organisation-types', 'FundOrganisationTypesController', ['only' => ['index', 'show']]);

    // Providers
    Route::resource('providers', 'ProviderController', ['except' => ['create', 'edit']]);
    Route::resource('providers.funds', 'ProviderFundsController', ['only' => ['index', 'show']]);

    // Countries
    Route::resource('countries', 'CountryController', ['except' => ['create', 'edit']]);
    Route::resource('countries.funds', 'CountryFundsController', ['only' => ['index', 'show']]);

    // Locations
    Route::resource('locations', 'LocationController', ['except' => ['create', 'edit']]);
    Route::resource('locations.funds', 'LocationFundsController', ['only' => ['index', 'show']]);

    // Regions
    Route::resource('regions', 'RegionController', ['except' => ['create', 'edit']]);
    Route::resource('regions.funds', 'RegionFundsController', ['only' => ['index', 'show']]);

    // Organisation Types
    Route::resource('organisation-types', 'OrganisationTypeController', ['except' => ['create', 'edit']]);
    Route::resource('organisation-types.funds', 'OrganisationTypeFundsController', ['only' => ['index', 'show']]);

    // Provision Types
    Route::resource('provision-types', 'ProvisionTypeController', ['except' => ['create', 'edit']]);
    Route::resource('provision-types.funds', 'ProvisionTypeFundsController', ['only' => ['index', 'show']]);

});
