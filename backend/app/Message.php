<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'description', 'time_sent', 'owner_id', 'event_id'
    ];
}
