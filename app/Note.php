<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    protected $fillable = [
        'body', 'blocked', 'user_id', 'status'
    ];
}
