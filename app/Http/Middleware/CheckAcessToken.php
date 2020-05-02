<?php

namespace App\Http\Middleware;

use Closure;

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
        $accessToken = $request->header('Authorization');
        if(Str::startsWith($accessToken, 'Bearer ')) {
            $accessToken = Str::substr($accessToken, 7);
        }
        $user = User::where('access_token',$accessToken)->first();
        if ($user === NULL) {
            return response()->json((object)['status' => 'Неверный токен'], 401);
        } else {
            $decodeAccessToken = base64_decode($accessToken);
            $explodeToken = explode("$", $decodeAccessToken);
            if (time() - $explodeToken[0] > 300000) {
                return response()->json((object)['status' => 'Время жизни токена вышло'], 402);
            }
        }
        return $next($request, $user);
    }
}
