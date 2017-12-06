<?php

namespace App\Modules\Orders\Models;

use App\Modules\Clients\Models\Cashier;
use App\Modules\Clients\Models\Client;
use App\Modules\Users\Models\User;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    protected $table = 'orders';
    protected $fillable = ['clients_id','code','status','output','expected_return','returned','subtotal','discount','interest','fines','total','obs','users_id'];

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

    public function user()
    {
        return $this->belongsTo(User::class,'users_id');
    }

    public function pays()
    {
        return $this->hasMany(OrderPayment::class, 'orders_id');
    }

    public function getItemsSituationAttribute($value)
    {
        switch ($value) {
            case 1:
                return "Aguardando";
                break;
            case 2:
                return "Em locação";
                break;
            case 3:
                return "Devolvidos";
                break;
        }
    }
}