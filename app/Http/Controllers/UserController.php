<?php

namespace App\Http\Controllers;

use App\Facades\WorkerTokensFacade;
use Illuminate\Http\Request;
use App\Facades\UserServicesFacade;

class UserController extends Controller
{
    public function login(Request $request) {
        $res = UserServicesFacade::loginUser(
            $request->input('email'),
            $request->input('password'),
            $request->getClientIp(),
            $request->userAgent()
        );
        return response()->json($res->result,$res->code);
    }

    public function register(Request $request) {
        $res = UserServicesFacade::registerUser(
            $request->input('first_name'),
            $request->input('last_name'),
            $request->input('email'),
            $request->input('password'),
            $request->getClientIp(),
            $request->userAgent()
        );
        return response()->json($res->result,$res->code);
    }

    public function refreshToken(Request $request) {
        $res = UserServicesFacade::refreshTokens(
            WorkerTokensFacade::parseBearerToToken($request->header('Authorization'))
        );
        return response()->json($res->result,$res->code);
    }
}
