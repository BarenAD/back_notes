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
            WorkerTokensFacade::parseBearerToToken($request->header('Authorization')),
            $request->input('body')
        );
        return response()->json($res->result,$res->code);
    }

    public function deleteNote(Request $request)
    {
        $res = NoteServicesFacade::deleteNote((int)  $request->input('id'));
        return response()->json($res->result,$res->code);
    }
}
