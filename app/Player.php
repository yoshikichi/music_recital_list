<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    //
    //belongsTo設定
    public function AdminUser()
    {
        return $this->belongsTo(AdminUser::class,'teacher_id');
    }
}
