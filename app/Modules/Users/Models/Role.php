<?php
/**
 * Created by PhpStorm.
 * User: alisson
 * Date: 20/11/2017
 * Time: 15:22
 */

namespace App\Modules\Users\Models;


use Illuminate\Database\Eloquent\Model;

class Role extends Model
{

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

}