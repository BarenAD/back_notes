<?php

namespace App\Http\Controllers;

use App\Facades\NoteServicesFacade;
use Illuminate\Http\Request;
use App\Facades\WorkerTokensFacade;

class NoteController extends Controller
{
    private function getUser($inToken)
    {
        return WorkerTokensFacade::getUserByToken(
            WorkerTokensFacade::parseBearerToToken($inToken)
        );
    }

    public function createNewNote(Request $request)
    {
        $user = $this->getUser($request->header('Authorization'));
        $res = NoteServicesFacade::createNewNote(
            $user->id,
            $request->input('body')
        );
        return response()->json($res->result,$res->code);
    }

    public function deleteNote(Request $request)
    {
        $user = $this->getUser($request->header('Authorization'));
        $res = NoteServicesFacade::deleteNote(
            $user->id,
            (int)  $request->input('id')
        );
        return response()->json($res->result,$res->code);
    }

    public function startСhanges(Request $request)
    {
        $user = $this->getUser($request->header('Authorization'));
        $res = NoteServicesFacade::startСhanges(
            $user->id,
            (int)  $request->input('id')
        );
        return response()->json($res->result,$res->code);
    }

    public function stopChanges(Request $request)
    {
        $user = $this->getUser($request->header('Authorization'));
        $res = NoteServicesFacade::stopChanges(
            $user->id,
            (int)  $request->input('id')
        );
        return response()->json($res->result,$res->code);
    }

    public function changeNote(Request $request)
    {
        $user = $this->getUser($request->header('Authorization'));
        $res = NoteServicesFacade::changeNote(
            $user->id,
            (int)  $request->input('id'),
            $request->input('body')
        );
        return response()->json($res->result,$res->code);
    }

    public function getAllNotes(Request $request)
    {
        $user = $this->getUser($request->header('Authorization'));
        $res = NoteServicesFacade::getAllNotes($user->id);
        return response()->json($res->result,$res->code)->header('X-My-Custom-Header', 'CustomValue');
    }

    public function completedNote(Request $request)
    {
        $user = $this->getUser($request->header('Authorization'));
        $res = NoteServicesFacade::completedNote(
            $user->id,
            (int)  $request->input('id')
        );
        return response()->json($res->result,$res->code);
    }
}
