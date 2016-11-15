<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    protected $fillable = [
        'rater_id', 'ratee_id', 'star'
    ];

    protected $table = 'rating';
}
