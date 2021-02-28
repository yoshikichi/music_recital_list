<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RecitalProgramMusic extends Model
{
    //belongsTo設定
    public function AdminUser()
    {
        return $this->belongsTo(AdminUser::class,'admin_user_id');
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
    public function musictitle()
    {
        return $this->belongsTo(Musictitle::class,'musictitle_id');
    }

    public function RecitalProgramOptions()
    {
        return $this->hasOne(RecitalProgramOptions::class,'recital_program_Option_id');
    }
}
