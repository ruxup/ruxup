<?php

namespace App;

use Illuminate\Database\Eloquent\Model;



class EventUser extends Model
{
    //Not plural
    protected $table='eventuser';
    protected $primaryKey = array('user_id', 'event_id');
}
