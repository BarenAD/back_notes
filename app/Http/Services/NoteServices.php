<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 02.05.20
 * Time: 11:32
 */

namespace App\Http\Services;

use App\Facades\WorkerTokensFacade;

class NoteServices
{
    public function createNewNote($accessToken) {
        $user = WorkerTokensFacade::getUserByToken($accessToken);
        return (object) ['result' => $user, 'code' => 200];
    }
}