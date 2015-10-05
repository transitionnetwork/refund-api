<?php

namespace App\Providers;

use App\Exceptions\CountryNotFoundException;
use App\Exceptions\FundNotFoundException;
use App\Exceptions\LocationNotFoundException;
use App\Exceptions\OrganisationTypeNotFoundException;
use App\Exceptions\ProvisionTypeNotFoundException;
use App\Exceptions\RegionNotFoundException;
use App\Exceptions\UserNotFoundException;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Routing\Router;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to the controller routes in your routes file.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @param \Illuminate\Routing\Router $router
     *
     * @return void
     */
    public function boot(Router $router)
    {
        //

        parent::boot($router);

        $router->model('users', 'App\User', function() {
            throw new UserNotFoundException;
        });

        $router->model('regions', 'App\Region', function() {
            throw new RegionNotFoundException;
        });

        $router->model('provision_types', 'App\ProvisionType', function() {
            throw new ProvisionTypeNotFoundException;
        });

        $router->model('funds', 'App\Fund', function() {
            throw new FundNotFoundException;
        });

        $router->model('providers', 'App\Provider', function() {
            throw new ProviderNotFoundException;
        });

        $router->model('organisation_types', 'App\OrganisationType', function() {
            throw new OrganisationTypeNotFoundException;
        });

        $router->model('locations', 'App\Location', function() {
            throw new LocationNotFoundException;
        });

        $router->model('countries', 'App\Country', function() {
            throw new CountryNotFoundException;
        });
    }

    /**
     * Define the routes for the application.
     *
     * @param \Illuminate\Routing\Router $router
     *
     * @return void
     */
    public function map(Router $router)
    {
        $router->group(['namespace' => $this->namespace], function ($router) {
            require app_path('Http/routes.php');
        });
    }
}
