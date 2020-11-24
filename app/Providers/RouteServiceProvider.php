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

    /**
     * The email of almacén Cancún.
     *
     * @var string
     */
    public const CUN = 'almacen.cun@vivaaerobus.com';

    /**
     * The email of almacén Guadalajara.
     *
     * @var string
     */
    public const GDL = 'almacen.gdl@vivaaerobus.com';

    /**
     * The email of almacén México.
     *
     * @var string
     */
    public const MEX = 'almacen.mex@vivaaerobus.com';

    /**
     * The email of almacén Monterrey.
     *
     * @var string
     */
    public const MTY = 'almacen.mty@vivaaerobus.com';

    /**
     * The email of almacén Tijuana.
     *
     * @var string
     */
    public const TIJ = 'almacen.tij@vivaaerobus.com';

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
