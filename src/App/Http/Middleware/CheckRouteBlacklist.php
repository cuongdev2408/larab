<?php

namespace CuongDev\Larab\App\Http\Middleware;

use App\Abstraction\Definition\DefineRoute;
use Closure;
use CuongDev\Larab\Abstraction\Definition\Message;
use CuongDev\Larab\Abstraction\Definition\StatusCode;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class CheckRouteBlacklist
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     * @throws Exception
     */
    public function handle(Request $request, Closure $next)
    {
        $blacklist = (new DefineRoute())->getBlacklist();
        if (Route::is($blacklist)) {
            $httpStatusCodes = (new StatusCode())->getHttpStatusCodes();
            throw new Exception($httpStatusCodes[StatusCode::HTTP_METHOD_NOT_ALLOWED], StatusCode::HTTP_METHOD_NOT_ALLOWED);
        }

        return $next($request);
    }
}
