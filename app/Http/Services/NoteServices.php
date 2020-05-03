<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 02.05.20
 * Time: 11:32
 */

namespace App\Http\Services;

use App\Note;

class NoteServices
{
    private function getAnAvailableNote($idNote, $idUser) {
        $note = Note::where('id',$idNote)->first();
        if (isset($note)) {
            if ($note->user_id === $idUser && $note->status == false) {
                if (time() - $note->blocked > 300) {
                    return $note;
                }
            }
        }
        return null;
    }

    public function createNewNote($idUser, $text_note) {
        if (isset($text_note) && strlen($text_note) > 5 && isset($idUser)) {
            $result = Note::create([
                'body' => $text_note,
                'blocked' => 0,
                'user_id' => $idUser,
                'status' => false
            ]);
            return (object) ['result' => $result, 'code' => 200];
        }
        return (object) ['result' => 'Не прислан текст или его длина меньше 5 символов', 'code' => 500];
    }

    public function stopChanges($idUser, $idNote) {
        if (isset($idNote) && isset($idUser)) {
            $note = Note::where('id',$idNote)->first();
            if (isset($note)) {
                if ($note->user_id === $idUser) {
                    $note->blocked = 0;
                    $note->save();
                    return (object)['result' => $note, 'code' => 200];
                }
            }
            return (object) ['result' => 'fail', 'code' => 500];
        }
        return (object) ['result' => 'Не прислан id', 'code' => 500];
    }

    public function startСhanges($idUser, $idNote) {
        if (isset($idNote) && isset($idUser)) {
            $note = $this->getAnAvailableNote($idNote,$idUser);
            if (isset($note)) {
                $note->blocked = time();
                $note->save();
                return (object)['result' => $note, 'code' => 200];
            }
            return (object) ['result' => 'fail', 'code' => 500];
        }
        return (object) ['result' => 'Не прислан id', 'code' => 500];
    }

    public function changeNote($idUser, $idNote, $newBodyNode) {
        if (isset($idNote) && isset($newBodyNode) && isset($idUser)) {
            $note = $this->getAnAvailableNote($idNote,$idUser);
            if (isset($note)) {
                $note->body = $newBodyNode;
                $note->blocked = 0;
                $note->save();
                return (object)['result' => $note, 'code' => 200];
            }
            return (object) ['result' => 'fail', 'code' => 500];
        }
        return (object) ['result' => 'Не прислан id или текст', 'code' => 500];
    }

    public function deleteNote($idUser, $idNote) {
        if (isset($idNote) && isset($idUser)) {
            $note = $this->getAnAvailableNote($idNote,$idUser);
            if (isset($note)) {
                $result = Note::where('id', $idNote)->delete();
                if ($result > 0) {
                    return (object)['result' => 'success', 'code' => 200];
                }
            }
            return (object) ['result' => 'fail', 'code' => 500];
        }
        return (object) ['result' => 'Не прислан id', 'code' => 500];
    }

    public function getAllNotes($idUser) {
        if (isset($idUser)) {
            return (object)[
                'result' => $note = Note::where('user_id',$idUser)->cursor(),
                'code' => 200
            ];
        }
        return (object)['result' => 'не авторизован', 'code' => 401];
    }

    public function completedNote($idUser, $idNote) {
        if (isset($idNote) && isset($idUser)) {
            $note = $this->getAnAvailableNote($idNote,$idUser);
            if (isset($note)) {
                $note->status = true;
                $note->blocked = 0;
                $note->save();
                return (object)['result' => $note, 'code' => 200];
            }
            return (object) ['result' => 'fail', 'code' => 500];
        }
        return (object) ['result' => 'Не прислан id или текст', 'code' => 500];
    }
}