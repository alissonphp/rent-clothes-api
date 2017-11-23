<?php

namespace App\Modules\Clients\Models;

use App\Modules\Orders\Models\Order;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{

    protected $table = 'clients';
    protected $fillable = ['name','cpf','email','phone','address','number','complement','neighborhood','city','uf','zipcode'];

    public function orders()
    {
        return $this->hasMany(Order::class, 'clients_id');
    }

}