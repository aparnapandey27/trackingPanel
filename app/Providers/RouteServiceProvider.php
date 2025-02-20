<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * This is used by Laravel authentication to redirect users after login.
     *
     * @var string
     */
    public const HOME = '/admin/dashboard';

    /**
     * The controller namespace for the application.
     *
     * When present, controller route declarations will automatically be prefixed with this namespace.
     *
     * @var string|null
     */
    // protected $namespace = 'App\\Http\\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */

     protected function mapAuthRoutes()
    {
        require base_path('routes/auth.php');
    }
    public function boot()
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            Route::prefix('api')
                ->middleware('api')
                ->namespace($this->namespace)
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/web.php'));

            Route::prefix('admin')
                ->as('admin.')
                ->middleware(['web', 'admin'])
                ->namespace($this->namespace)
                ->group(base_path('routes/admin.php'));

            //Advertiser Route Group with separate file
            Route::prefix('advertiser')
                ->as('advertiser.')
                ->middleware(['web', 'advertiser'])
                ->namespace($this->namespace)
                ->group(base_path('routes/advertiser.php'));

            //student Route Group with separate file
            Route::prefix('student')
                ->as('student.')
                ->middleware(['web', 'student'])
                ->namespace($this->namespace)
                ->group(base_path('routes/student.php'));

            //Employee Route Group with separate file
            Route::prefix('employee')
                ->as('employee.')
                ->middleware(['web', 'employee'])
                ->namespace($this->namespace)
                ->group(base_path('routes/employee.php'));
        });
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by(optional($request->user())->id ?: $request->ip());
        });
    }

}
