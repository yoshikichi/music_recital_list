<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RecitalProgram extends Model
{
    //belongsTo設定
    public function AdminUser()
    {
        return $this->belongsTo(AdminUser::class,'teacher_id');
    }
    //belongsTo設定
    public function Recital()
    {
        return $this->belongsTo(Recital::class,'recital_id');
    }
    //belongsTo設定
    public function Player()
    {
        return $this->belongsTo(Player::class,'player_id');
    }
     //belongsTo設定
    public function music1()
    {
        return $this->belongsTo(Musictitle::class,'music1_id');
    }
    //belongsTo設定
    public function music2()
    {
        return $this->belongsTo(Musictitle::class,'music2_id');
    }
    //belongsTo設定
    public function music3()
    {
        return $this->belongsTo(Musictitle::class,'music3_id');
    }
    //belongsTo設定
    public function music4()
    {
        return $this->belongsTo(Musictitle::class,'music4_id');
    }
    //belongsTo設定
    public function music5()
    {
        return $this->belongsTo(Musictitle::class,'music5_id');
    }
}
