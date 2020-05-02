<?php

namespace App\Http\Controllers;

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
        if ($request->getContentType() == "json") {
            $res = UserServicesFacade::registerUser(
                $request->input('first_name'),
                $request->input('last_name'),
                $request->input('email'),
                $request->input('password'),
                $request->getClientIp(),
                $request->userAgent()
            );
            return response()->json($res->result,$res->code);
        } else {
            return response()->json((object) [
                "status" => "Не поддерживаемый тип данных!"
            ], 415);
        }
    }
}
