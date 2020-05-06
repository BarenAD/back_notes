<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware(['content_type.check'])->group(function () {

    Route::prefix('/user')->group(function () {
        Route::post('/register', 'UserController@register');
        Route::post('/login', 'UserController@login');
        Route::get('/refreshToken', 'UserController@refreshToken');
    });

    Route::middleware(['access.check'])->group(function () {
        Route::get('/user/logout', 'UserController@logout');

        Route::prefix('/note')->group(function () {
            Route::get('/getAll', 'NoteController@getAllNotes');
            Route::post('/create', 'NoteController@createNewNote');
            Route::post('/delete', 'NoteController@deleteNote');
            Route::prefix('/change')->group(function () {
                Route::post('/start', 'NoteController@startСhanges');
                Route::post('/stop', 'NoteController@stopChanges');
                Route::post('/change', 'NoteController@changeNote');
                Route::post('/completed', 'NoteController@completedNote');
            });
        });
    });
});