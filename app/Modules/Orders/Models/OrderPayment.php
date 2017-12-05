<?php

namespace App\Modules\Orders\Models;

use App\Modules\Users\Models\User;
use Illuminate\Database\Eloquent\Model;

class OrderPayment extends Model
{

    protected $table = 'order_payments';
    protected $fillable = ['users_id','orders_id','value'];

    public function order()
    {
        return $this->belongsTo(Order::class, 'orders_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }

}