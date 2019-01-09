<?php

namespace App\Http\Middleware;

use App\Exceptions\LogicException;
use App\Http\Config\AdminConfig;
use App\Tools\Sign\ParamsSignature;
use Closure;

class ProtectCookData
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
        if (config(AdminConfig::PROTECT_COOK)){
            if (!$request->sign)
                throw new LogicException(LogicException::EXCEPTION_SIGN_ERROR);
            ParamsSignature::check($request->all());
        }
        return $next($request);
    }
}
