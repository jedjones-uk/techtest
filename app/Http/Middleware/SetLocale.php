<?php namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SetLocale {

    /**
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next) {
        if ($request->has('locale')) {
            app()->setLocale($request->get('locale'));
        }
        return $next($request);
    }
}
