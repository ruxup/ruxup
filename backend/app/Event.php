<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'location', 'start_time', 'end_time', 'description', 'image', 'owner_id',
    ];
}
