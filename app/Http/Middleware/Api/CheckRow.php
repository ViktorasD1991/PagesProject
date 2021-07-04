<?php

namespace App\Http\Middleware\Api;

use App\Models\Rows;
use Closure;

class CheckRow
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
        $row = Rows::where('page_id', '=', $request->route()->parameter('pageId'))
            ->where('id', '=', $request->route()->parameter('rowId'))
            ->first();

        if (empty($row)) {
            return response()->json(['Row not found or does not belong to this page'], 404);
        }

        return $next($request);
    }
}
