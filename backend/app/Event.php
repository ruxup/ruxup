<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'name', 'location', 'start_time', 'end_time', 'category', 'description', 'image', 'owner_id',
    ];

    public $timestamps = false;
}
