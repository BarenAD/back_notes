<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 02.05.20
 * Time: 10:33
 */

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class NoteServicesFacade extends Facade
{
    protected static function getFacadeAccessor() {
        return 'service.note.services'; // алиас из сервис-провайдера
    }
}