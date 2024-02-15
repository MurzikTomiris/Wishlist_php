<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Accounts;


class EnsureTokenIsValid
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
            //обращаемся в базу и ищем его
            //если нашли то записываем в арибуты  request

        $request->bearerToken();
        $token = $request->header('token');
        if ($token) {
        $user = Accounts::where('token', $token)->first();
        $request->token = $token;
        return $next($request);
        }
        return response()->json(['error' => 'Unauthorized'], 401);
    }
}
