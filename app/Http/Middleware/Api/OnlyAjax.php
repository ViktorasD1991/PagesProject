<?php

namespace App\Http\Middleware\Api;

use App;

class OnlyAjax
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, \Closure $next)
    {
        if (!$request->ajax() && App::environment() !== 'local') {
            return response()->json(['error' => 'Forbidden'], 403);
        }

        return $next($request);
    }
}
