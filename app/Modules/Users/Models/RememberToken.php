<?php
/**
 * Created by PhpStorm.
 * User: Alisson
 * Date: 10/12/2017
 * Time: 20:14
 */

namespace App\Modules\Users\Models;


use Illuminate\Database\Eloquent\Model;

class RememberToken extends Model
{
    protected $table = 'remember_token';
    protected $fillable = ['users_id','token','expired_at'];

    public function user()
    {
        return $this->belongsTo(User::class,'users_id');
    }
}