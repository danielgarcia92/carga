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
    public const AEROPUERTOS_ACA = 'aca.apto@vivaaerobus.com';
    /** @var string */
    public const AEROPUERTOS_BJX = 'bjx.apto@vivaaerobus.com';
    /** @var string */
    public const AEROPUERTOS_CEN = 'cen.apto@vivaaerobus.com';
    /** @var string */
    public const AEROPUERTOS_CJS = 'cjs.apto@vivaaerobus.com';
    /** @var string */
    public const AEROPUERTOS_CUL = 'cul.apto@vivaaerobus.com';
    /** @var string */
    public const AEROPUERTOS_CUN = 'cun.apto@vivaaerobus.com';
    /** @var string */
    public const AEROPUERTOS_CUU = 'cuu.apto@vivaaerobus.com';
    /** @var string */
    public const AEROPUERTOS_DGO = 'dgo.apto@vivaaerobus.com';
    /** @var string */
    public const AEROPUERTOS_GDL = 'gdl.apto@vivaaerobus.com';
    /** @var string */
    public const AEROPUERTOS_HMO = 'hmo.apto@vivaaerobus.com';
    /** @var string */
    public const AEROPUERTOS_HUX = 'hux.apto@vivaaerobus.com';
    /** @var string */
    public const AEROPUERTOS_LAP = 'lap.apto@vivaaerobus.com';
    /** @var string */
    public const AEROPUERTOS_MEX = 'mex.apto@vivaaerobus.com';
    /** @var string */
    public const AEROPUERTOS_MID = 'mid.apto@vivaaerobus.com';
    /** @var string */
    public const AEROPUERTOS_MLM = 'mlm.apto@vivaaerobus.com';
    /** @var string */
    public const AEROPUERTOS_MTY = 'mty.apto@vivaaerobus.com';
    /** @var string */
    public const AEROPUERTOS_MXL = 'mxl.apto@vivaaerobus.com';
    /** @var string */
    public const AEROPUERTOS_MZT = 'mzt.apto@vivaaerobus.com';
    /** @var string */
    public const AEROPUERTOS_OAX = 'oax.apto@vivaaerobus.com';
    /** @var string */
    public const AEROPUERTOS_PBC = 'pbc.apto@vivaaerobus.com';
    /** @var string */
    public const AEROPUERTOS_PXM = 'pxm.apto@vivaaerobus.com';
    /** @var string */
    public const AEROPUERTOS_REX = 'rex.apto@vivaaerobus.com';
    /** @var string */
    public const AEROPUERTOS_SJD = 'sjd.apto@vivaaerobus.com';
    /** @var string */
    public const AEROPUERTOS_SLP = 'slp.apto@vivaaerobus.com';
    /** @var string */
    public const AEROPUERTOS_TAM = 'tam.apto@vivaaerobus.com';
    /** @var string */
    public const AEROPUERTOS_TGZ = 'tgz.apto@vivaaerobus.com';
    /** @var string */
    public const AEROPUERTOS_TRC = 'trc.apto@vivaaerobus.com';
    /** @var string */
    public const AEROPUERTOS_VER = 'ver.apto@vivaaerobus.com';
    /** @var string */
    public const AEROPUERTOS_VSA = 'vsa.apto@vivaaerobus.com';
    /** @var string */
    public const AEROPUERTOS_ZCL = 'zcl.apto@vivaaerobus.com';
    /** @var string */
    public const AEROPUERTOS_ZIH = 'zih.apto@vivaaerobus.com';
    /** @var string */
    public const AEROPUERTOS_PVR = 'pvr.apto@vivaaerobus.com';
    /** @var string */
    public const AEROPUERTOS_TIJ = 'tij.apto@vivaaerobus.com';

    /** @var string */
    public const SOBRECARGO_1_MTY = 'mty.operaciones@vivaaerobus.com';
    /** @var string */
    public const SOBRECARGO_2_MTY = 'diana.mora@vivaaerobus.com';
    /** @var string */
    public const SOBRECARGO_1_GDL = 'ops.gdl@vivaaerobus.com';
    /** @var string */
    public const SOBRECARGO_2_GDL = 'luis.buenrostro@vivaaerobus.com';
    /** @var string */
    public const SOBRECARGO_1_TIJ = 'ivan.pacheco@vivaaerobus.com';
    /** @var string */
    public const SOBRECARGO_2_TIJ = 'ramon.ramos@vivaaerobus.com';
    /** @var string */
    public const SOBRECARGO_3_TIJ = 'vicente.cortes@vivaaerobus.com';
    /** @var string */
    public const SOBRECARGO_1_CUN = 'isai.fernandez@vivaaerobus.com';
    /** @var string */
    public const SOBRECARGO_2_CUN = 'ops.cun@vivaaerobus.com';
    /** @var string */
    public const SOBRECARGO_1_MEX = 'ops.mex@vivaaerobus.com';
    /** @var string */
    public const SOBRECARGO_2_MEX = 'mex.trafico@menziesaviation.com';

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
