<?php
/**
 * Created by IntelliJ IDEA.
 * User: scoce95461
 * Date: 1/27/16
 * Time: 11:11 AM
 */

namespace Smorken\Sanitizer;

use Illuminate\Support\ServiceProvider as SP;
use Smorken\Sanitizer\Contracts\Sanitize;

class ServiceProvider extends SP
{

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->bootConfig();
    }

    /**
     * Register any application services.
     *
     * This service provider is a great spot to register your various container
     * bindings with the application. As you can see, we are registering our
     * "Registrar" implementation here. You can add your own bindings too!
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(Sanitize::class, function ($app) {
            return new \Smorken\Sanitizer\Sanitize($app['config']->get('sanitizer', []));
        });
    }

    protected function bootConfig()
    {
        $config = __DIR__.'/../config/config.php';
        $app_path = config_path('sanitizer.php');
        $this->mergeConfigFrom($config, 'sanitizer');
        $this->publishes([$config => $app_path], 'config');
    }
}
