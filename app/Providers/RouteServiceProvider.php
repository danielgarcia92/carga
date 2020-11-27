<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * The path to the "home" route for your application.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * The path to the "form" route for your application.
     *
     * @var string
     */
    public const FORM = '/uploads';

    /** @var string */
    public const ALMACEN_CUN = 'almacen.cun@vivaaerobus.com';
    /** @var string */
    public const ALMACEN_GDL = 'almacen.gdl@vivaaerobus.com';
    /** @var string */
    public const ALMACEN_MEX = 'almacen.mex@vivaaerobus.com';
    /** @var string */
    public const ALMACEN_MTY = 'almacen.mty@vivaaerobus.com';
    /** @var string */
    public const ALMACEN_TIJ = 'almacen.tij@vivaaerobus.com';

    /** @var string */
    public const SAEROCHARTER_CUN = 'supervisor-cargo-cun@aerocharter.com.mx';
    /** @var string */
    public const MAEROCHARTER_CUN = 'mostrador-cargo-cun@aerocharter.com.mx';
    /** @var string */
    public const SAEROCHARTER_GDL = 'supervisor-cargo-gdl@aerocharter.com.mx';
    /** @var string */
    public const MAEROCHARTER_GDL = 'mostrador-cargo-gdl@aerocharter.com.mx';
    /** @var string */
    public const SAEROCHARTER_MEX = 'supervisor-cargo-mex@aerocharter.com.mx';
    /** @var string */
    public const MAEROCHARTER_MEX = 'mostrador-cargo-mex@aerocharter.com.mx';
    /** @var string */
    public const SAEROCHARTER_MTY = 'supervisor-cargo-mty@aerocharter.com.mx';
    /** @var string */
    public const MAEROCHARTER_MTY = 'mostrador-cargo-mty@aerocharter.com.mx';
    /** @var string */
    public const SAEROCHARTER_TIJ = 'supervisor-cargo-tij@aerocharter.com.mx';
    /** @var string */
    public const MAEROCHARTER_TIJ = 'mostrador-cargo-tij@aerocharter.com.mx';
    /** @var string */
    public const SAEROCHARTER_QRO = 'supervisor-cargo-qro@aerocharter.com.mx';
    /** @var string */
    public const MAEROCHARTER_QRO = 'mostrador-cargo-qro@aerocharter.com.mx';
    /** @var string */
    public const SAEROCHARTER_MID = 'supervisor-cargo-mid@aerocharter.com.mx';
    /** @var string */
    public const MAEROCHARTER_MID = 'mostrador-cargo-mid@aerocharter.com.mx';
    /** @var string */
    public const SAEROCHARTER_OAX = 'supervisor-cargo-oax@aerocharter.com.mx';
    /** @var string */
    public const MAEROCHARTER_OAX = 'mostrador-cargo-oax@aerocharter.com.mx';
    /** @var string */
    public const SAEROCHARTER_SJD = 'supervisor-cargo-sjd@aerocharter.com.mx';
    /** @var string */
    public const MAEROCHARTER_SJD = 'mostrador-cargo-sjd@aerocharter.com.mx';
    /** @var string */
    public const SAEROCHARTER_CJS = 'supervisor-cargo-cjs@aerocharter.com.mx';
    /** @var string */
    public const MAEROCHARTER_CJS = 'mostrador-cargo-cjs@aerocharter.com.mx';
    /** @var string */
    public const SAEROCHARTER_CUL = 'supervisor-cargo-cul@aerocharter.com.mx';
    /** @var string */
    public const MAEROCHARTER_CUL = 'mostrador-cargo-cul@aerocharter.com.mx';


    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();

        //
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/api.php'));
    }
}
