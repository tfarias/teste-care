<?php

namespace LaravelMetronic\Http\Middleware;

use Closure;
use LaravelMetronic\Models\AuxCiclo;

class ViewComposer
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        view()->composer(['sis_usuario.ciclos'],function($view) {
            $ciclos = AuxCiclo::orderBy('ano','DESC')->get();
            $view->with('ciclos',$ciclos);
        });
        return $next($request);
    }
}
