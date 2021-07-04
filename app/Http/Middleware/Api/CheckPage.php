<?php

namespace App\Http\Middleware\Api;

use App\Models\Pages;
use Closure;

class CheckPage
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
        $page = Pages::find($request->route()->parameter('pageId'));

        if(empty($page)){
           return response()->json(['Page not found or you do not have access to it.'],404);
        }

        return $next($request);
    }
}
