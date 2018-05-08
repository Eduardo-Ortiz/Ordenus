<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Equivalence extends Model
{
    //
    public $timestamps = false;

    protected $fillable = [
        'from_id', 'to_id', 'ratio'
    ];

}
