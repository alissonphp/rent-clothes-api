<?php

namespace App\Modules\Orders\Models;

use App\Modules\Clients\Models\Client;
use App\Modules\Items\Models\Item;
use App\Modules\Items\Models\ItemSize;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{

    protected $table = 'order_items';
    protected $fillable = ['orders_id','item_sizes_id','days','subtotal'];
    public $timestamps = false;

    public function order()
    {
        return $this->belongsTo(Order::class, 'orders_id');
    }

    public function itemsize() {
        return $this->belongsTo(ItemSize::class, 'item_sizes_id')->with('item');
    }
}