<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AllAnswer extends Model
{
    public function quesiton()
    {
        return $this->belongsTo('App\Question');
    }
}
