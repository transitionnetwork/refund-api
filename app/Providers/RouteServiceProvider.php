<?php

namespace App\Providers;

use App\Exceptions\FundNotFoundException;
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

        $router->model('users', 'App\User');
        $router->model('regions', 'App\Region');
        $router->model('provision_types', 'App\ProvisionType');
        $router->model('funds', 'App\Fund', function() {
            throw new FundNotFoundException;
        });
        $router->model('providers', 'App\Provider');
        $router->model('organisation_types', 'App\OrganisationType');
        $router->model('locations', 'App\Location');
        $router->model('countries', 'App\Country');
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
