<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 02.05.20
 * Time: 11:32
 */

namespace App\Http\Services;

use App\Facades\WorkerTokensFacade;
use App\Note;

class NoteServices
{
    public function createNewNote($accessToken, $text_note) {
        if (isset($text_note) && strlen($text_note) > 5) {
            $user = WorkerTokensFacade::getUserByToken($accessToken);
            $result = Note::create([
                'body' => $text_note,
                'blocked' => 0,
                'user_id' => $user->id
            ]);
            return (object) ['result' => $result, 'code' => 200];
        }
        return (object) ['result' => 'Не прислан текст или его длина меньше 5 символов', 'code' => 500];
    }

    public function deleteNote($idNote) {
        if (isset($idNote)) {
            $note = Note::where('id',$idNote)->first();
            if (isset($note)) {
                if (time() - $note->blocked > 300000) {
                    $result = Note::where('id',$idNote)->delete();
                    if ($result > 0) {
                        return (object) ['result' => 'success', 'code' => 200];
                    }
                }
            }
            return (object) ['result' => 'fail', 'code' => 500];
        }
        return (object) ['result' => 'Не прислан id', 'code' => 500];
    }
}