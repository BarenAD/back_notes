<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 02.05.20
 * Time: 11:32
 */

namespace App\Http\Services;

use App\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class WorkerTokens
{
    public function parseBearerToToken($token) {
        if(Str::startsWith($token, 'Bearer ')) {
            return(Str::substr($token, 7));
        }
        return $token;
    }

    public function getUserByToken($accessToken) {
        $user = null;
        if (Cache::has($accessToken)) {
            $user = Cache::get($accessToken);
        } else {
            $user = User::where('access_token',$accessToken)->firstOrFail();
        }
        return $user;
    }
}