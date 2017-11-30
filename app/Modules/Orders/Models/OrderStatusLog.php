<?php

namespace App\Modules\Orders\Models;

use App\Modules\Users\Models\User;
use Illuminate\Database\Eloquent\Model;

class OrderStatusLog extends Model
{

    protected $table = 'order_status_log';
    protected $fillable = ['orders_id','users_id','status'];

    public function order()
    {
        return $this->belongsTo(Order::class, 'orders_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'users_id');
    }
}