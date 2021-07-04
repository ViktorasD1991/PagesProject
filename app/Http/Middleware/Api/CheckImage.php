<?php

namespace App\Http\Middleware\Api;

use App\Models\Elements;
use App\Models\Images;
use App\Models\Pages;
use Closure;

class CheckImage
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $image = Images::where('id', '=', $request->route()->parameter('imageId'))->first();

        $elements = Elements::where('data', '=', $image->path)->first();

        if(!empty($elements)){
            return response()->json(['This image is used in one or more pages.'],403);
        }

        return $next($request);
    }
}
