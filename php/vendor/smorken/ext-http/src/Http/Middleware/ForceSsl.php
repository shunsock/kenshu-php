<?php
/**
 * Created by IntelliJ IDEA.
 * User: scoce95461
 * Date: 6/16/16
 * Time: 10:54 AM
 */

namespace Smorken\Ext\Http\Middleware;

use Closure;

class ForceSsl
{

    protected $skip_secure = [
        'local',
        'vagrant',
        'testing',
    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!$request->secure() && !in_array(app()->environment(), $this->skip_secure)) {
            return redirect()->secure($request->path());
        }
        return $next($request);
    }
}
