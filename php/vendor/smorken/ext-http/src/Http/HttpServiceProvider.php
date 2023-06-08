<?php
/**
 * Created by IntelliJ IDEA.
 * User: scoce95461
 * Date: 5/11/17
 * Time: 9:34 AM
 */

namespace Smorken\Ext\Http;

use Illuminate\Support\ServiceProvider;

class HttpServiceProvider extends ServiceProvider
{

    public function boot()
    {
        include_once __DIR__ . '/helpers.php';
    }

    public function register()
    {

    }
}
