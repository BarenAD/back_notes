<?php

namespace App\Http\Controllers;

use App\Facades\NoteServicesFacade;
use Illuminate\Http\Request;
use App\Facades\WorkerTokensFacade;

class NoteController extends Controller
{
    public function createNewNote(Request $request)
    {
        $res = NoteServicesFacade::createNewNote(
            WorkerTokensFacade::parseBearerToToken($request->header('Authorization'))
        );
        return response()->json($res->result,$res->code);
    }
}
