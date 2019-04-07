<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RecitalProgram extends Model
{
    //belongsTo設定
    public function AdminUser()
    {
        return $this->belongsTo('App\AdminUser','id'.'teacher_id');
    }
    //belongsTo設定
    public function Recital()
    {
        return $this->belongsTo('App\Recital','id'.'recital_id');
    }
    //belongsTo設定
    public function Player()
    {
        return $this->belongsTo('App\Player','id'.'player_id');
    }
     //belongsTo設定
    public function music1()
    {
        return $this->belongsTo('App\Musictitle','id'.'music1_id');
    }
    //belongsTo設定
    public function music2()
    {
        return $this->belongsTo('App\Musictitle','id'.'music2_id');
    }
}
