<?php

namespace Aminpciu\CrudAutomation\app\Middleware;

use Closure;
use Illuminate\Http\Request;
use Aminpciu\CrudAutomation\app\Helper\CommonTrait;
class CrudAutomationMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        //dd($request);
        $res=CommonTrait::getConfig();
        if(!$res)
            return redirect()->route("crud-automation.aminpciu");
        return $next($request);
    }
}
