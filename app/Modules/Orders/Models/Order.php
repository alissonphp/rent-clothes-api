<?php

namespace App\Modules\Orders\Models;

use App\Modules\Clients\Models\Cashier;
use App\Modules\Clients\Models\Client;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    protected $table = 'orders';
    protected $fillable = ['clients_id','code','status','output','expected_return','returned','subtotal','discount','interest','fines','total','obs'];

    public function client()
    {
        return $this->belongsTo(Client::class, 'clients_id');
    }

    public function cashier()
    {
        return $this->hasOne(Cashier::class, 'orders_id');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class,'orders_id')->with('itemsize');
    }

    public function logStatus()
    {
        return $this->hasMany(OrderStatusLog::class, 'orders_id');
    }
}