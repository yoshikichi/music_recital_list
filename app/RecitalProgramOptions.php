<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RecitalProgramOptions extends Model
{

    public function RecitalProgramMusic()
    {
        return $this->belongsTo('App\RecitalProgramMusic');
    }


}
