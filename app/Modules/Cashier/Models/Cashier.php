<?php

namespace App\Modules\Cashier\Models;

use App\Modules\Orders\Models\Order;
use App\Modules\Users\Models\User;
use Illuminate\Database\Eloquent\Model;

class Cashier extends Model
{

    protected $table = 'cashier';
    protected $fillable = ['id','users_id','orders_id','total','method'];

    public function order()
    {
        return $this->belongsTo(Order::class, 'orders_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    public function commissions()
    {
        return $this->hasMany(SellerCommission::class,'cashiers_id');
    }

}