<?php

namespace App\Modules\Users\Models;

use App\Modules\Clients\Models\Cashier;
use App\Modules\Goals\Models\Goals;
use App\Modules\Orders\Models\Order;
use App\Modules\Orders\Models\OrderPayment;
use App\Modules\Orders\Models\OrderStatusLog;
use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Model implements AuthenticatableContract, AuthorizableContract, JWTSubject
{
    use Authenticatable, Authorizable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','email','password','provider','provider_id','avatar_url','remember_token'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_roles','users_id','roles_id');
    }

    public function cashier()
    {
        return $this->hasMany(Cashier::class, 'users_id');
    }

    public function logStatus()
    {
        return $this->hasMany(OrderStatusLog::class, 'orders_id');
    }
    public function orders()
    {
        return $this->hasMany(Order::class,'users_id');
    }

    public function pays()
    {
        return $this->hasMany(OrderPayment::class, 'users_id');
    }

    public function goals()
    {
        return $this->hasMany(Goals::class, 'users_id');
    }
}
