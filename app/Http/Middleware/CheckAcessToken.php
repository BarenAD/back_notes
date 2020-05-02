<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Cache;
use App\Facades\WorkerTokensFacade;

class CheckAcessToken
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
        $accessToken = WorkerTokensFacade::parseBearerToToken($request->header('Authorization'));
        $user = WorkerTokensFacade::getUserByToken($accessToken);
        if ($user === NULL) {
            return response()->json((object)['status' => 'Неверный токен'], 401);
        } else {
            $decodeAccessToken = base64_decode($accessToken);
            $explodeToken = explode("$", $decodeAccessToken);
            if (time() - $explodeToken[0] > 300000) {
                return response()->json((object)['status' => 'Время жизни токена вышло'], 402);
            }
        }
        Cache::put($accessToken, $user, 300);
        return $next($request, $user);
    }
}
