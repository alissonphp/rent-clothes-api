<?php

namespace App\Modules\Goals\Models;

use App\Modules\Users\Models\User;
use Illuminate\Database\Eloquent\Model;

class Goals extends Model
{

    protected $table = 'goals';
    protected $fillable = ['month','year','goal_seller','commission_seller','goal_store','commission_store','users_id'];

    public function user()
    {
        return $this->belongsTo(User::class,'users_id');
    }

}